using MySql.Data.MySqlClient;
using System;
using System.Data;
using System.Drawing;
using System.Windows.Forms;

namespace LaundryShopDesktopCounterpart
{
    public class DashboardForm : Form
    {
        Panel content = new Panel();
        string currentUser;

        public DashboardForm(string user)
        {
            currentUser = user;
            Text = "Laundry Shop Desktop Counterpart";
            WindowState = FormWindowState.Maximized;
            StartPosition = FormStartPosition.CenterScreen;
            BackColor = Color.FromArgb(12, 16, 32);

            Panel sidebar = new Panel
            {
                Width = 240,
                Dock = DockStyle.Left,
                BackColor = Color.FromArgb(20, 28, 55)
            };

            Label brand = new Label
            {
                Text = "⚡ LAUNDRY\\nSHOP",
                ForeColor = Color.White,
                Font = new Font("Segoe UI", 20, FontStyle.Bold),
                AutoSize = false,
                Height = 110,
                Dock = DockStyle.Top,
                TextAlign = ContentAlignment.MiddleCenter
            };

            sidebar.Controls.Add(brand);
            AddNav(sidebar, "Dashboard", ShowDashboard);
            AddNav(sidebar, "Customers", () => ShowTable("customers"));
            AddNav(sidebar, "Services", () => ShowTable("services"));
            AddNav(sidebar, "Products", () => ShowTable("products"));
            AddNav(sidebar, "Orders", () => ShowTable("orders"));
            AddNav(sidebar, "Payments", () => ShowTable("payments"));
            AddNav(sidebar, "Reports", ShowReports);
            AddNav(sidebar, "Logout", () => { new LoginForm().Show(); Close(); });

            content.Dock = DockStyle.Fill;
            content.BackColor = Color.FromArgb(12, 16, 32);

            Controls.Add(content);
            Controls.Add(sidebar);

            ShowDashboard();
        }

        void AddNav(Panel sidebar, string text, Action action)
        {
            Button btn = new Button
            {
                Text = text,
                Dock = DockStyle.Top,
                Height = 55,
                FlatStyle = FlatStyle.Flat,
                ForeColor = Color.White,
                BackColor = Color.FromArgb(20, 28, 55),
                Font = new Font("Segoe UI", 11, FontStyle.Bold)
            };
            btn.FlatAppearance.BorderSize = 0;
            btn.Click += (s, e) => action();
            sidebar.Controls.Add(btn);
            btn.BringToFront();
        }

        Label Header(string title)
        {
            return new Label
            {
                Text = title,
                ForeColor = Color.White,
                Font = new Font("Segoe UI", 24, FontStyle.Bold),
                AutoSize = true,
                Location = new Point(35, 30)
            };
        }

        void ShowDashboard()
        {
            content.Controls.Clear();
            content.Controls.Add(Header("Dashboard"));

            Label welcome = new Label
            {
                Text = "Welcome, " + currentUser,
                ForeColor = Color.LightGray,
                Font = new Font("Segoe UI", 12),
                AutoSize = true,
                Location = new Point(40, 80)
            };
            content.Controls.Add(welcome);

            AddCard("Customers", CountTable("customers").ToString(), 40, 140);
            AddCard("Services", CountTable("services").ToString(), 330, 140);
            AddCard("Products", CountTableSafe("products").ToString(), 620, 140);
            AddCard("Orders", CountTable("orders").ToString(), 910, 140);

            AddCard("Total Sales", "₱" + GetScalar("SELECT IFNULL(SUM(amount_paid),0) FROM payments WHERE payment_status='Paid'"), 40, 340);
        }

        void AddCard(string title, string value, int x, int y)
        {
            Panel card = new Panel
            {
                Location = new Point(x, y),
                Size = new Size(250, 145),
                BackColor = Color.FromArgb(35, 55, 95)
            };

            Label t = new Label
            {
                Text = title,
                ForeColor = Color.LightGray,
                Font = new Font("Segoe UI", 12),
                AutoSize = true,
                Location = new Point(20, 22)
            };

            Label v = new Label
            {
                Text = value,
                ForeColor = Color.White,
                Font = new Font("Segoe UI", 26, FontStyle.Bold),
                AutoSize = true,
                Location = new Point(20, 65)
            };

            card.Controls.Add(t);
            card.Controls.Add(v);
            content.Controls.Add(card);
        }

        int CountTable(string table)
        {
            return int.Parse(GetScalar($"SELECT COUNT(*) FROM {table}"));
        }

        int CountTableSafe(string table)
        {
            try { return CountTable(table); } catch { return 0; }
        }

        string GetScalar(string sql)
        {
            using var con = Database.GetConnection();
            con.Open();
            using var cmd = new MySqlCommand(sql, con);
            return Convert.ToString(cmd.ExecuteScalar()) ?? "0";
        }

        void ShowTable(string table)
        {
            content.Controls.Clear();
            content.Controls.Add(Header(table.ToUpper()));

            DataGridView grid = new DataGridView
            {
                Location = new Point(40, 110),
                Size = new Size(1050, 560),
                BackgroundColor = Color.FromArgb(20, 28, 55),
                ForeColor = Color.Black,
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill
            };

            try
            {
                using var con = Database.GetConnection();
                con.Open();
                using var da = new MySqlDataAdapter("SELECT * FROM " + table + " ORDER BY id DESC", con);
                DataTable dt = new DataTable();
                da.Fill(dt);
                grid.DataSource = dt;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Unable to load " + table + ":\\n" + ex.Message);
            }

            content.Controls.Add(grid);
        }

        void ShowReports()
        {
            content.Controls.Clear();
            content.Controls.Add(Header("Reports"));

            DataGridView grid = new DataGridView
            {
                Location = new Point(40, 110),
                Size = new Size(1100, 560),
                BackgroundColor = Color.FromArgb(20, 28, 55),
                ForeColor = Color.Black,
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill
            };

            string sql = @"
                SELECT 
                    o.id AS order_id,
                    c.customer_name,
                    s.service_name,
                    o.weight,
                    o.total_amount,
                    o.status,
                    p.payment_status,
                    p.amount_paid
                FROM orders o
                INNER JOIN customers c ON o.customer_id = c.id
                INNER JOIN services s ON o.service_id = s.id
                LEFT JOIN payments p ON o.id = p.order_id
                ORDER BY o.id DESC";

            try
            {
                using var con = Database.GetConnection();
                con.Open();
                using var da = new MySqlDataAdapter(sql, con);
                DataTable dt = new DataTable();
                da.Fill(dt);
                grid.DataSource = dt;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Unable to load reports:\\n" + ex.Message);
            }

            content.Controls.Add(grid);
        }
    }
}
