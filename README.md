# Base repository

This repository is the core of my thesis.
This skeleton is based on the Laravel Framework, which has thorough [documentation](https://laravel.com).

## Setup

To initialize the project run the `init.sh` script:
```bash
./init.sh
```
This script install dependecies via `composer`, creates a `.env` file, and sets up the app key.
In this file set all necessary configurations, like database connection settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DATABASE_NAME>
DB_USERNAME=<DB_USERNAME>
DB_PASSWORD=<DB_PASSWORD>
```
## Setting up the database
After the database connection is set up correctly, migrations, and seeders can be run with the following:
```bash
php artisan migrate
```
During project development, run this command to update the tables.
If you want to import the `mitigai_feladat1.xlsx` file, use the `--seed` option.
To make a fresh migration, which drops all tables and recreate them run:
```bash
php artisan migrate:fresh
```

## Starting the dev server
After the initial configurations, the dev server can be started like:
```bash
php artisan serve
```
