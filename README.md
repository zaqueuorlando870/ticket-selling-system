```markdown
# Ticket Selling System

A Laravel-based ticketing platform for creating events, managing seat reservations, and handling attendee purchases. Built with Laravel, Livewire, TailwindCSS, and AlpineJS.

## Features

- Create and manage events
- Seat selection and real-time reservation
- Attendee information collection
- Assign attendee role upon purchase
- Role-based access with Spatie Permissions
- Search and filter events and transactions

## Installation

1. Clone the repository

```bash
git clone https://github.com/zaqueuorlando870/ticket-selling-system.git
cd ticket-selling-system
```

2. Install dependencies

```bash
composer install
npm install && npm run build
```

3. Create your `.env` file

```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with your database credentials

5. Run migrations

```bash
php artisan migrate
```

6. Set up roles (using Spatie Permission)

```bash
php artisan tinker
```

Inside Tinker:

```php
use Spatie\Permission\Models\Role;

Role::create(['name' => 'admin']);
Role::create(['name' => 'attendee']);
```

## Simulate a Ticket Purchase

1. Create an event and seats

```bash
php artisan tinker
```

```php
\App\Models\Event::create(['title' => 'Live Concert', 'price' => 5000, 'user_id' => 1]);

\App\Models\Seat::insert([
    ['event_id' => 1, 'label' => 'A1'],
    ['event_id' => 1, 'label' => 'A2'],
    ['event_id' => 1, 'label' => 'A3']
]);
```

2. Visit `http://localhost:8000/events` in your browser

3. View seats, select one, and complete the form to simulate a purchase

## Useful Commands

| Task                           | Command                      |
|--------------------------------|-------------------------------|
| Start server                   | `php artisan serve`           |
| Compile assets                 | `npm run build`               |
| Watch for changes              | `npm run dev`                 |
| Run migrations                 | `php artisan migrate`         |
| Clear cache/config             | `php artisan optimize:clear` |
| View route list                | `php artisan route:list`      |

## Roles

- **admin**: can manage events and view purchases
- **attendee**: automatically assigned after a ticket purchase

## License

This project is open-sourced under the MIT license.
```