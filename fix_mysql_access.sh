#!/bin/bash
# Check current root user settings
echo "Current root user configuration:"
sudo mysql -u root -proot -e "SELECT user, host, plugin FROM mysql.user WHERE user='root';"

echo ""
echo "Setting up proper access for HeidiSQL connection..."

# Create a new user for external connections
sudo mysql -u root -proot -e "CREATE USER IF NOT EXISTS 'hrms_admin'@'%' IDENTIFIED BY 'hrms2026';"
sudo mysql -u root -proot -e "GRANT ALL PRIVILEGES ON hrms.* TO 'hrms_admin'@'%';"
sudo mysql -u root -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1';"
sudo mysql -u root -proot -e "FLUSH PRIVILEGES;"

echo ""
echo "Setup complete! You can now connect with:"
echo "User: hrms_admin"
echo "Password: hrms2026"
echo "Host: 127.0.0.1"
echo "Port: 3306"
echo "Database: hrms"
