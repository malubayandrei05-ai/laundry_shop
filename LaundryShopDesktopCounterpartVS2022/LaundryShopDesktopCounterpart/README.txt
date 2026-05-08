# Laundry Shop Desktop Counterpart

Open `LaundryShopDesktopCounterpart.sln` in Visual Studio 2022.

## Requirements
- Visual Studio 2022
- .NET 6 Desktop Runtime / SDK
- XAMPP MySQL running
- Existing database: `laundry_shop`
- NuGet package: `MySql.Data`

## Database connection
The app connects to the same database as your PHP web system:

```csharp
server=localhost;user=root;password=;database=laundry_shop;
```

Edit `Database.cs` if your MySQL password is different.

## Default Login
Username: admin  
Password: admin123

## Connected System
Your PHP web system and this desktop app share the same MySQL database.
If you add records in the web app, they will appear in this desktop app.
