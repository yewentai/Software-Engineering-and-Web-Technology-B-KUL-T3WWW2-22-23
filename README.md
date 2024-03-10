# Bookbinder Project

The Bookbinder project is a Symfony-based application designed to offer a platform for book enthusiasts. It allows users to explore books, subscribe to their favorites, comment on books, and interact with other users. This document outlines the project's structure and provides instructions on how to get started.

## Project Structure

The project is organized into several key directories:

- **bin/**: Contains the Symfony console script.
- **config/**: Configuration files for bundles, services, routes, and more.
- **public/**: Publicly accessible directory containing front-end resources.
- **src/**: The PHP source code of the project, including entities, controllers, repositories, forms, and security components.
- **templates/**: Twig templates for rendering HTML content.
- **tests/**: PHPUnit tests for functional testing and utility classes.

### Key Components

- **Entity/**: Entity classes representing the database models such as `Book`, `Comment`, `Subscribe`, and `User`.
- **Controller/**: Controllers handling web requests for home page, book details, user registration, login, and user profiles.
- **Form/**: Form classes for handling user registration and commenting.
- **Repository/**: Repository classes for querying the database.
- **Security/**: Components related to authentication and user management.

## Getting Started

### Requirements

- PHP 7.4 or higher
- Composer for managing PHP dependencies
- Symfony CLI for running the local web server
- MySQL or similar database engine
- Docker and Docker Compose (optional) for containerization

### Installation

1. Clone the repository to your local machine.
2. Navigate to the project directory and install PHP dependencies with Composer:

   ```bash
   composer install
   ```

3. Configure the `.env` file with your database connection details.

4. Create the database and run migrations:

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Load sample data into the database with fixtures (optional):

   ```bash
   php bin/console doctrine:fixtures:load
   ```

6. Start the local web server with Symfony CLI:

   ```bash
   symfony server:start
   ```

7. Access the application in your web browser at the address provided by the Symfony CLI.

### Running Tests

Execute PHPUnit tests using the following command:

```bash
php ./vendor/bin/phpunit
```

## Contributing

Contributions to the Bookbinder project are welcome. Please ensure that any pull requests are well-documented and include appropriate tests when necessary.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
