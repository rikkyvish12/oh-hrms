#!/bin/bash
# Set root password and grant permissions
mysql -u root -proot -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON hrms.* TO 'root'@'localhost';"
mysql -u root -proot -e "FLUSH PRIVILEGES;"
echo "Database setup completed successfully!"
