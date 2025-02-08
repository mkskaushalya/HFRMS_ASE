# HFRMS_ASE Project

## Overview
HFRMS_ASE is a Laravel-based application designed to manage hall locations and related functionalities. This project aims to provide a robust and scalable solution for managing various hall locations, their statuses, and other related data.

## Directory Structure
- **app/**: Contains the core application logic, including models, controllers, and services.
- **bootstrap/**: Contains files for bootstrapping the application.
- **config/**: Contains configuration files for various aspects of the application.
- **database/**: 
  - **factories/**: Defines model factories for generating test data.
  - **migrations/**: Contains migration files for database schema changes.
  - **seeders/**: Contains seed classes that populate the database with initial data.
- **public/**: Contains the front-facing files of the application.
- **resources/**: Contains views, language files, and other resources.
- **routes/**: Contains route definitions for the application.
- **storage/**: Used for storing logs, compiled views, and other generated files.
- **tests/**: Contains test files for the application.

## Migration Files
- **2025_02_08_193415_create_hall_locations_table.php**: Creates the 'hall_locations' table with columns 'id', 'location', 'status' (defaulting to 'active'), and timestamps.
- **2025_02_09_000000_add_new_column_to_hall_locations_table.php**: Intended to add a new column to the 'hall_locations' table.

## Installation
1. Clone the repository.
2. Run `composer install` to install PHP dependencies.
3. Run `npm install` to install JavaScript dependencies.
4. Set up your `.env` file with the appropriate database credentials.
5. Run `php artisan migrate` to create the database tables.

## Usage
After setting up the application, you can access it via your web browser. Use the provided routes to manage hall locations and perform related operations.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.