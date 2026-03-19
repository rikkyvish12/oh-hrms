#!/bin/bash
echo "Fixing MySQL authentication for root user..."

# Change root authentication to use password instead of socket
sudo mysql -u root -proot << 'EOF'
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';
FLUSH PRIVILEGES;
EOF

echo ""
echo "Testing connection with new password..."
mysql -u root -proot -e "SELECT 'Connection successful!' AS status;"

echo ""
echo "Setup complete! You can now connect in HeidiSQL with:"
echo "Host: 127.0.0.1 or localhost"
echo "User: root"
echo "Password: root"
echo "Port: 3306"
echo "Database: hrms"
