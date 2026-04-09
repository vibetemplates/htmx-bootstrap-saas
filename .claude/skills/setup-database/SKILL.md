---
name: setup-database
description: Set up the MariaDB database for the vibe_templates application on a fresh Ubuntu server. Use this skill whenever the user mentions database setup, database migration, server provisioning, setting up the app on a new server, configuring MariaDB/MySQL for this project, or running the initial database configuration. This is one of the first things done after cloning the repository onto a new server.
---

# Database Setup Skill

This skill configures the MariaDB database for the htmx-bootstrap-saas application on a fresh Ubuntu server. It assumes MariaDB is already installed and `mysql_secure_installation` has been run.

## Prerequisites

- MariaDB is installed and running on the server
- `sudo mysql_secure_installation` has been completed (root password: `#VibeTemplate$`)
- The repository has been cloned to the server
- You are running commands from the repository root directory

## Steps

Execute these steps in order. If any step fails, stop and report the error to the user before continuing.

### Step 1: Generate a random password

Generate a secure random password for the `vibe_templates` database user. Use `openssl` since it's available on Ubuntu:

```bash
openssl rand -base64 18
```

Store this password — you'll need it for the next two steps.

### Step 2: Create the database and user

Run the following SQL via the mysql command line, authenticated as root. Replace `GENERATED_PASSWORD` with the password from Step 1:

```bash
sudo mysql -u root -p'#VibeTemplate$' <<'EOSQL'
CREATE DATABASE IF NOT EXISTS vibe_templates CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'vibe_templates'@'localhost' IDENTIFIED BY 'GENERATED_PASSWORD';
GRANT ALL PRIVILEGES ON vibe_templates.* TO 'vibe_templates'@'localhost';
FLUSH PRIVILEGES;
EOSQL
```

The actual command must substitute the real generated password into the `IDENTIFIED BY` clause. Do not leave the placeholder.

### Step 3: Update config/database.php

Edit `config/database.php` and replace the value of `DB_PASS` with the generated password from Step 1. Only change the password constant — leave everything else untouched.

The line to change looks like:
```php
private const DB_PASS = 'old-password-here';
```

Replace it with:
```php
private const DB_PASS = 'your-generated-password';
```

### Step 4: Import the schema

Load the sample tables from `vibe_templates.sql` (located in the repository root) into the new database:

```bash
sudo mysql -u root -p'#VibeTemplate$' vibe_templates < vibe_templates.sql
```

### Step 5: Verify connectivity

Test that the application can connect using the new credentials:

```bash
php -r "
require 'config/database.php';
try {
    \$db = Database::getInstance()->getConnection();
    echo 'Database connection successful.' . PHP_EOL;
    \$tables = \$db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo 'Tables found: ' . count(\$tables) . PHP_EOL;
    foreach (\$tables as \$t) echo '  - ' . \$t . PHP_EOL;
} catch (Exception \$e) {
    echo 'Connection FAILED: ' . \$e->getMessage() . PHP_EOL;
    exit(1);
}
"
```

If the connection succeeds and tables are listed, the setup is complete. If it fails, check:
- MariaDB is running (`sudo systemctl status mariadb`)
- The password in `config/database.php` matches what was used in the CREATE USER statement
- The `vibe_templates` database exists (`sudo mysql -u root -p'#VibeTemplate$' -e "SHOW DATABASES;"`)

### Step 6: Commit the updated config

After successful verification, commit the updated `config/database.php` with a message like:
```
Update database password for new server deployment
```

Push the changes to the repository.
