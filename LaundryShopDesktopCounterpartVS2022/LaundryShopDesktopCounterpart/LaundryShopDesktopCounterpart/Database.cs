using MySql.Data.MySqlClient;

namespace LaundryShopDesktopCounterpart
{
    public static class Database
    {
        public static string ConnectionString =
            "server=localhost;user=root;password=;database=laundry_shop;";

        public static MySqlConnection GetConnection()
        {
            return new MySqlConnection(ConnectionString);
        }
    }
}
