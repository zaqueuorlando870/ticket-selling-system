# Ticket Selling System

A Laravel-based ticketing platform for creating events, managing seat reservations, and handling attendee purchases. This system is designed to be scalable, secure, and easy to use.

---

## Features

- **Event Management**: Create and manage events with details such as date, time, and seat availability.
- **Seat Management**: Create and manage seats with details such as seat number and availability.
- **Seat Reservation**: Attendees can reserve seats for events.
- **Concurrency Control**: Ensures that only one attendee can reserve a seat at a time, preventing multiple reservations for the same seat.
- **Real-time Updates**: Seat availability is updated in real-time, ensuring that attendees can see the latest availability.
- **Attendee Information Collection**: Collect attendee information such as name and email.
- **Assign Attendee Role**: Assign attendee role upon purchase.
- **Role-Based Access**: Role-based access control using Spatie Permissions.
- **Search and Filter**: Search and filter events and transactions.

---

## Technical Details

- Built with **Laravel 8.x**
- Uses **MySQL** as the database management system
- Utilizes Laravel's built-in features such as **Eloquent**, **Validation**, and **Queueing**
- Follows best practices for coding standards and security
- **Code organization**: Code is organized into separate folders for each feature, making it easy to navigate and understand.
- **Testing**: Includes a comprehensive set of unit tests and feature tests to ensure the system is working as expected.
- **Dependency Management**: Uses Composer to manage dependencies and ensure consistent versions.

---

## Installation

1. Clone the repository to your local machine:
   ```bash
   git clone https://github.com/yourusername/ticket-selling-system.git
   cd ticket-selling-system
   ```

2. Install the dependencies:
   ```bash
   composer install
   ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run the migrations to set up the database:
   ```bash
   php artisan migrate
   ```

6. Seed the database with initial data (optional):
   ```bash
   php artisan db:seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

---

## Running Tests

To run the test suite, execute the following command:

```bash
php artisan test
php artisan test --group=feature
```

This will run all unit and feature tests to ensure the system functions as expected.