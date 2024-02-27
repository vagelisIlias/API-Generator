
## Project Ticket Generator

This project generates and processes tickets through console commands and provides API endpoints for managing tickets.

## Table of Contents

- [Installation](#installation)
- [Console Commands](#console-commands)
- [API Endpoints](#api-endpoints)
- [Tests](#tests)

## Install Composer

```composer install```



## Generate Ticket

```php artisan app:generate-ticket```

## Process Ticket

```php artisan app:process-ticket```

## API Endpoints

```http://ticket-generator.test/api/tickets/open```

```http://ticket-generator.test/api/tickets/closed```

```http://ticket-generator.test/api/users/add-user-email-here-to-check-it/tickets```

```http://ticket-generator.test/api/stats```

## Run Tests

```php artisan test```