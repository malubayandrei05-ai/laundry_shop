using MySql.Data.MySqlClient;
using System;
using System.Drawing;
using System.Windows.Forms;

namespace LaundryShopDesktopCounterpart
{
    public class LoginForm : Form
    {
        TextBox txtUsername = new TextBox();
        TextBox txtPassword = new TextBox();

        public LoginForm()
        {
            Text = "Laundry Shop Login";
            StartPosition = FormStartPosition.CenterScreen;
            Size = new Size(460, 520);
            BackColor = Color.FromArgb(18, 18, 32);
            FormBorderStyle = FormBorderStyle.FixedSingle;
            MaximizeBox = false;

            Label title = new Label
            {
                Text = "⚡ Laundry Shop",
                ForeColor = Color.White,
                Font = new Font("Segoe UI", 24, FontStyle.Bold),
                AutoSize = true,
                Location = new Point(80, 60)
            };

            Label subtitle = new Label
            {
                Text = "Desktop Counterpart System",
                ForeColor = Color.LightGray,
                Font = new Font("Segoe UI", 10),
                AutoSize = true,
                Location = new Point(125, 110)
            };

            txtUsername.PlaceholderText = "Username";
            txtUsername.Font = new Font("Segoe UI", 12);
            txtUsername.Location = new Point(80, 175);
            txtUsername.Width = 290;

            txtPassword.PlaceholderText = "Password";
            txtPassword.Font = new Font("Segoe UI", 12);
            txtPassword.Location = new Point(80, 230);
            txtPassword.Width = 290;
            txtPassword.PasswordChar = '*';

            Button btnLogin = new Button
            {
                Text = "LOGIN",
                Width = 290,
                Height = 45,
                Location = new Point(80, 300),
                BackColor = Color.FromArgb(64, 156, 255),
                ForeColor = Color.White,
                FlatStyle = FlatStyle.Flat,
                Font = new Font("Segoe UI", 11, FontStyle.Bold)
            };
            btnLogin.Click += BtnLogin_Click;

            Label note = new Label
            {
                Text = "Default: admin / admin123",
                ForeColor = Color.LightGray,
                AutoSize = true,
                Location = new Point(145, 365)
            };

            Controls.Add(title);
            Controls.Add(subtitle);
            Controls.Add(txtUsername);
            Controls.Add(txtPassword);
            Controls.Add(btnLogin);
            Controls.Add(note);
        }

        private void BtnLogin_Click(object? sender, EventArgs e)
        {
            try
            {
                using var con = Database.GetConnection();
                con.Open();

                string sql = "SELECT * FROM users WHERE username=@username AND password=@password";
                using var cmd = new MySqlCommand(sql, con);
                cmd.Parameters.AddWithValue("@username", txtUsername.Text.Trim());
                cmd.Parameters.AddWithValue("@password", txtPassword.Text.Trim());

                using var reader = cmd.ExecuteReader();

                if (reader.Read())
                {
                    string name = reader["name"].ToString() ?? "User";
                    DashboardForm dashboard = new DashboardForm(name);
                    dashboard.Show();
                    Hide();
                }
                else
                {
                    MessageBox.Show("Invalid username or password.", "Login Failed");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Database connection error:\\n" + ex.Message);
            }
        }
    }
}
