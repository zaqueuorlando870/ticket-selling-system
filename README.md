### 📄 `README.md`

```markdown
# 🎟️ Ticket Selling System

This is a Laravel-based ticket selling system using Livewire, TailwindCSS, AlpineJS, and Laravel Breeze for authentication.

---

## 🚀 Features

- Event creation and seat management
- Seat reservation with attendee registration
- Prevents overbooking
- Role-based user system (`admin`, `attendee`)
- Real-time interaction using Livewire

---

## 🛠 Installation Instructions

### 1. Clone the repository

```bash
git clone https://github.com/zaqueuorlando870/ticket-selling-system.git
cd ticket-selling-system
```

### 2. Install dependencies

```bash
composer install
npm install && npm run build
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

> 🔧 Set your database credentials in the `.env` file.

### 4. Run migrations and seed roles

```bash
php artisan migrate
php artisan db:seed
```

> Make sure the roles `admin` and `attendee` are seeded or created manually if needed.

### 5. Serve the application

```bash
php artisan serve
```

Access your app at: [http://localhost:8000](http://localhost:8000)

---

## 👤 Default Roles

- New users created through seat purchase are assigned the `attendee` role.
- Admins can view all events and manage them.

You can manage roles using [spatie/laravel-permission](https://github.com/spatie/laravel-permission).

---

## 📦 Tech Stack

- Laravel
- Livewire
- Tailwind CSS
- Alpine.js
- Laravel Breeze (Auth)
- Spatie Permission Package

---

## 🙋‍♂️ Author

Developed by [Zaqueu Orlando](https://github.com/zaqueuorlando870)

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).
```
