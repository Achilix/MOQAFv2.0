# MOQAF Backend Setup Guide

## Project Overview

MOQAF is a gig-based handyman marketplace application with:

-   **Backend**: Laravel 12 REST API
-   **Frontend**: Separate (React, Vue, or mobile app)
-   **Authentication**: Laravel Sanctum (token-based)
-   **Database**: MySQL

---

## Prerequisites

-   PHP ^8.2
-   Composer
-   MySQL/MariaDB
-   Node.js (for frontend build tools)

---

## Installation Steps

### 1. Clone and Install Dependencies

```bash
cd MOQAF
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moqaf
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

### 4. Storage Setup (for file uploads)

```bash
php artisan storage:link
php artisan config:publish laravel/sanctum
```

### 5. Start Development Server

```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Queue Listener (optional)
php artisan queue:listen

# Terminal 3: Frontend Dev (if applicable)
npm run dev
```

The API will be available at: **http://localhost:8000/api/v1**

---

## API Structure

### Routes

-   **Web Routes**: `routes/web.php` - Traditional web interface (optional)
-   **API Routes**: `routes/api.php` - REST API for mobile/frontend apps

### Controllers

-   `app/Http/Controllers/Api/Auth/` - Authentication endpoints
-   `app/Http/Controllers/Api/GigController.php` - Gig management
-   `app/Http/Controllers/Api/OrderController.php` - Order workflow
-   `app/Http/Controllers/Api/UserController.php` - User profiles
-   `app/Http/Controllers/Api/ChatController.php` - Messaging

### Models

-   `User` - User authentication and profile
-   `Handyman` - Handyman services and profile
-   `Client` - Client profile
-   `Gig` - Service offerings
-   `Order` - Service orders/jobs
-   `Conversation` - Chat conversations
-   `Message` - Chat messages
-   `Country`, `City` - Location data

---

## Authentication Flow

### For Mobile/Frontend Apps

#### 1. Register

```javascript
POST /api/v1/auth/register
{
  "fname": "John",
  "lname": "Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Response:

```json
{
  "access_token": "1|Hdgk5GNnB8VKP...",
  "user": {...}
}
```

#### 2. Login

```javascript
POST /api/v1/auth/login
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### 3. Use Token for Requests

```javascript
fetch("http://localhost:8000/api/v1/user", {
    headers: {
        Authorization: "Bearer YOUR_ACCESS_TOKEN",
    },
});
```

#### 4. Logout

```javascript
POST /api/v1/auth/logout
Headers: Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

## User Types

### Client

-   Can browse gigs
-   Can place orders
-   Can communicate with handymen
-   Can rate completed work

### Handyman

-   Can create gigs (service offerings)
-   Can accept/reject orders
-   Can complete orders
-   Can communicate with clients
-   Can view their profile

### Becoming a Handyman

User can convert to handyman by calling:

```
POST /api/v1/user/become-handyman
{
  "services": ["electrical", "plumbing"],
  "bio": "Expert technician with 10 years experience"
}
```

---

## Order Workflow

```
Client creates order -> Handyman sees notification
                    -> Handyman accepts/rejects
                    -> Work is done
                    -> Handyman marks complete
                    -> Client can rate
```

### Order Statuses

-   **pending** - Waiting for handyman response
-   **accepted** - Handyman accepted
-   **rejected** - Handyman rejected
-   **completed** - Order finished
-   **cancelled** - Order cancelled

---

## File Upload Configuration

### Avatar Upload

-   Endpoint: `POST /api/v1/user/avatar`
-   Max size: 2MB
-   Formats: jpeg, png, jpg, gif
-   Storage: `storage/app/public/avatars/`

### Gig Photos

-   Store as JSON array in gig model
-   Use `POST /gigs` with `photos` array

---

## CORS Configuration

By default, CORS is enabled for:

-   `http://localhost:3000` (React)
-   `http://localhost:5173` (Vite)
-   `http://localhost:8000` (Local testing)
-   Custom: Set `FRONTEND_URL` in `.env`

To add more origins, edit `config/cors.php`:

```php
'allowed_origins' => [
    'https://yourdomain.com',
    'https://app.yourdomain.com',
],
```

---

## Environment Variables

```env
# App
APP_NAME=MOQAF
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=moqaf
DB_USERNAME=root
DB_PASSWORD=

# Email (optional)
MAIL_FROM_ADDRESS=noreply@moqaf.com
MAIL_FROM_NAME="MOQAF"

# File Storage
FILESYSTEM_DISK=public

# Queue (background jobs)
QUEUE_CONNECTION=database
```

---

## Testing

Run tests with Pest:

```bash
php artisan test
```

### Example Test

```php
test('user can login', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertOk();
    $response->assertHasToken();
});
```

---

## Common Issues & Solutions

### CORS Error

**Problem**: "Access to XMLHttpRequest blocked by CORS"

**Solution**:

1. Update `.env` with correct `FRONTEND_URL`
2. Check `config/cors.php` allowed_origins
3. Ensure API is serving on correct port

### Token Expired

**Problem**: 401 Unauthorized on requests

**Solution**:

1. User needs to login again
2. Implement token refresh (optional)

### File Upload Issues

**Problem**: Files not saving

**Solution**:

```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

---

## Development Workflow

### 1. Create Migration

```bash
php artisan make:migration create_table_name
```

### 2. Create Model

```bash
php artisan make:model ModelName -m
```

### 3. Create Controller

```bash
php artisan make:controller Api/ResourceController
```

### 4. Register Route in `routes/api.php`

```php
Route::apiResource('resources', 'Api\ResourceController');
```

### 5. Test Endpoint

```bash
curl -X GET http://localhost:8000/api/v1/resources
```

---

## Useful Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database
php artisan migrate:refresh --seed

# Create seeder
php artisan make:seeder UserSeeder

# Run specific seeder
php artisan db:seed --class=UserSeeder

# View database
php artisan tinker
> User::all()

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Generate API documentation
# (Add to your workflow)
```

---

## API Documentation

See [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for complete endpoint reference.

---

## Next Steps

1. **Setup Database** - Run migrations and seeders
2. **Test API** - Use Postman or curl to test endpoints
3. **Build Frontend** - Create React/Vue/Mobile app
4. **Implement Features**:
    - Payment integration (Stripe, PayPal)
    - Email notifications
    - Push notifications
    - Search & filters
    - Ratings & reviews
5. **Deploy** - Use Heroku, AWS, or your hosting

---

## Support & Troubleshooting

For issues, check:

1. `.env` configuration
2. Database connection
3. Migration status: `php artisan migrate:status`
4. Route list: `php artisan route:list`
5. Logs: `storage/logs/laravel.log`

---
