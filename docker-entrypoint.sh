#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until php -r "new mysqli('ci_mysql', 'root', 'root', 'ci_app');" > /dev/null 2>&1; do
  echo "Waiting for MySQL..."
  sleep 2
done
echo "MySQL is ready!"

# Run migrations (this will always run)
echo "Running migrations..."
php /var/www/html/index.php migrate

# Check if the users table is empty (only run seeding if it is empty)
echo "Checking if users table is empty..."
TABLE_CHECK=$(php -r "echo (new mysqli('ci_mysql', 'root', 'root', 'ci_app'))->query('SELECT COUNT(*) FROM users')->fetch_row()[0];")

# If the users table is empty, run seeding
if [ "$TABLE_CHECK" -eq 0 ]; then
    echo "Users table is empty, running database seeding..."

    # Run seeding
    php /var/www/html/index.php seed

else
    echo "Users table already populated, skipping seeding."
fi

# Execute the default command (start Apache)
exec "$@"
