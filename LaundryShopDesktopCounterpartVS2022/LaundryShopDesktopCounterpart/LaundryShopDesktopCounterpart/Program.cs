using System;
using System.Windows.Forms;

namespace LaundryShopDesktopCounterpart
{
    internal static class Program
    {
        [STAThread]
        static void Main()
        {
            ApplicationConfiguration.Initialize();
            Application.Run(new LoginForm());
        }
    }
}
