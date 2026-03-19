#!/bin/bash
echo "Current migrations in database:"
mysql -u root -proot hrms -e "SELECT * FROM migrations ORDER BY id;"

echo ""
echo "Removing duplicate salary_slips migration record..."
mysql -u root -proot hrms -e "DELETE FROM migrations WHERE migration = '2026_03_16_200925_create_salary_slips_table';"

echo ""
echo "Updated migrations list:"
mysql -u root -proot hrms -e "SELECT * FROM migrations ORDER BY id;"
