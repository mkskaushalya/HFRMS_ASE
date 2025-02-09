name: "Hall and Facility Rental Management System"

on:
  push:
    branches: ["main"]
  pull_request:
    branches: ["main"]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: "8.0"

      - name: Copy .env
        run: php -r "file_exists('.env') || copy('.env.example', '.env');"

      - name: Install Dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

      - name: Generate key
        run: php artisan key:generate

      - name: Directory Permissions
        run: chmod -R 777 storage bootstrap/cache

      - name: Install MySQL
        run: sudo apt-get install -y mysql-server

      - name: Start MySQL service
        run: sudo service mysql start

      - name: Create Database
        run: |
          sudo mysql -e "CREATE DATABASE IF NOT EXISTS ${{ secrets.DB_DATABASE }};" -u${{ secrets.DB_USERNAME }} -p${{ secrets.DB_PASSWORD }}

      - name: Run Migrations
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: ${{ secrets.DB_DATABASE }}
          DB_USERNAME: ${{ secrets.DB_USERNAME }}
          DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
        run: php artisan migrate --seed

      - name: Execute tests (Unit and Feature tests) via PHPUnit/Pest
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: ${{ secrets.DB_DATABASE }}
          DB_USERNAME: ${{ secrets.DB_USERNAME }}
          DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
        run: php artisan test
