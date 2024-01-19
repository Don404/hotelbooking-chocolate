
# Hotel Booking System API

## Introduction
This project is a RESTful API for a Hotel Booking System. It is designed to manage hotel rooms, bookings, customer interactions, and payment records.

## Getting Started

### Prerequisites
- PHP >= 7.3
- Composer
- Laravel >= 8.x
- MySQL or any Laravel-supported database system

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Don404/hotelbooking-chocolate.git
   ```

2. Navigate to the project directory:
   ```bash
   cd hotelbooking-chocolate
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Create a `.env` file and configure your environment variables (especially the database settings).

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. (Optional) Seed the database:
   ```bash
   php artisan db:seed
   ```

8. Start the local development server:
   ```bash
   php artisan serve
   ```

## API Documentation

### Base URL
The base URL for the API is `http://localhost:8000/api`.

### Authentication
This API uses token-based authentication. Include the token in the header of your requests:

```
Authorization: Bearer YOUR_API_TOKEN
```

### Endpoints

#### Room Management
- **GET /rooms**: List all rooms.
- **POST /rooms**: Create a new room.
- **GET /rooms/{id}**: Get details of a specific room.

#### Booking Management
- **POST /bookings**: Create a new booking.
- **GET /bookings**: List all bookings.

#### Customer Management
- **POST /customers**: Add a new customer.
- **GET /customers**: List all customers.

#### Payment Recording
- **POST /payments**: Record a new payment.

## Authors
- Andon Grozev - *Initial work*
