# System-Tabulation PHP Website Setup Guide

This guide will help you set up and run the System-Tabulation PHP website on XAMPP.

## Prerequisites

Make sure you have [XAMPP](https://www.apachefriends.org/index.html) installed on your machine.

## Steps to Set Up the System-Tabulation Website

1. **Download the Repository:**
   - Clone or download the System-Tabulation repository from [GitHub](https://github.com/your_username/System-Tabulation).

2. **Navigate to XAMPP's `htdocs` directory:**
   - Copy the downloaded repository folder and paste it inside the `htdocs` directory of your XAMPP installation. (The path might look like `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS.)

3. **Start XAMPP:**
   - Open XAMPP Control Panel and start the Apache and MySQL services.

4. **Access phpMyAdmin:**
   - Open your web browser and go to `http://localhost/phpmyadmin`.

5. **Create a Database:**
   - Click on the "Databases" tab and create a new database named `system_tabulation`.

6. **Import the Database File:**
   - Locate the `database_file` folder inside the downloaded repository.
   - Find the database file (e.g., `system_tabulation.sql`) provided within this folder.
   - In phpMyAdmin, select the `system_tabulation` database you created.
   - Click on the "Import" tab, choose the database file, and click "Go" to import the data into the `system_tabulation` database.

7. **Configure Database Connection:**
   - Navigate to the `System-Tabulation` repository folder.
   - Look for a configuration file, typically named `config.php` or similar, that contains database connection settings.
   - Update the database connection details (hostname, username, password, database name) if required to match your local setup.

8. **Access the Website:**
   - Open your web browser and go to `http://localhost/System-Tabulation` or the appropriate URL where the website is located in your `htdocs` directory.

9. **Login and Test:**
   - Use any provided credentials to log in to the System-Tabulation website and verify that everything is working correctly.

## Troubleshooting

- If you encounter any issues with database connections or other errors, ensure that your XAMPP services (Apache, MySQL) are running and the database credentials in the configuration files are correctly set.

Enjoy using the System-Tabulation website!
