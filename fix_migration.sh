#!/bin/bash
mysql -u root -proot hrms -e "DELETE FROM migrations WHERE migration = '2026_03_16_200925_create_salary_slips_table';"
echo "Migration record deleted successfully!"
