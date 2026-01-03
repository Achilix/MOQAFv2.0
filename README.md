# MOQAF - Handyman Service Platform

A modern, full-featured handyman service marketplace platform built with Laravel and Vue.js. MOQAF connects customers with skilled handymen for various services including plumbing, electrical work, carpentry, painting, and more.

## Features

### Core Platform Features

-   **User Management**: Comprehensive user authentication and role-based access control (Clients, Handymen, Admins)
-   **Service Listings**: Browse and search handyman services across multiple categories
-   **Handyman Profiles**: Detailed profiles with skills, ratings, reviews, and service history
-   **Booking System**: Easy-to-use booking and order management
-   **Messaging System**: Real-time chat between clients and handymen
-   **Review & Rating System**: Client feedback and service quality ratings
-   **Notification System**: Email and in-app notifications for bookings and updates

### Advanced Features

-   **Fiverr-Style Tiered Pricing**: Handymen can offer three pricing tiers for each service:
    -   **BASIC**: Entry-level service for small/quick jobs
    -   **MEDIUM**: Standard service for apartment-sized projects
    -   **PREMIUM**: Comprehensive service for full-house projects
-   **Dynamic Pricing Model**: Each tier includes:
    -   Customizable service description
    -   Price per tier
    -   Delivery/completion timeframe
-   **Smart Search & Filtering**: Filter gigs by service type, location, price range, and ratings
-   **Responsive Design**: Mobile-friendly interface for iOS and Android browsers

## Tech Stack

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: Vue.js 3 with Vite
-   **Database**: MySQL/PostgreSQL
-   **Authentication**: Laravel Sanctum (API tokens)
-   **Real-time**: Laravel Echo & Pusher/Reverb
-   **CSS**: Tailwind CSS

## Project Structure

```
MOQAF/
├── app/
│   ├── Models/              # Eloquent models
│   │   ├── User.php
│   │   ├── Gig.php
│   │   ├── GigTier.php      # NEW: Pricing tier model
│   │   ├── Order.php
│   │   ├── Review.php
│   │   ├── Message.php
│   │   ├── Notification.php
│   │   └── ...
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/         # API controllers
│   │   │   │   ├── GigController.php
│   │   │   │   ├── TierController.php  # NEW: Pricing tier API
│   │   │   │   ├── OrderController.php
│   │   │   │   └── ...
│   │   ├── Requests/        # Form validation
│   │   └── Resources/       # API resource transformation
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database schemas
│   │   └── *_create_gig_tiers_table.php  # NEW: Pricing tiers table
│   └── seeders/
│       └── GigTierSeeder.php # NEW: Sample pricing tier data
├── resources/
│   ├── views/               # Blade templates
│   │   ├── gig-detail.blade.php      # Shows pricing tiers
│   │   ├── my-gigs.blade.php         # Handyman dashboard with tier summary
│   │   ├── gigs/edit.blade.php       # Tier management form
│   │   └── ...
│   ├── js/                  # Vue.js components
│   └── css/                 # Tailwind CSS
├── routes/
│   └── api.php              # API routes including tier endpoints
└── tests/                   # Feature and unit tests
```

## Installation & Setup

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js & npm
-   MySQL/PostgreSQL database

### Setup Steps

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd MOQAF
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Configure environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Setup database**

    ```bash
    php artisan migrate
    php artisan db:seed  # Optional: seed with sample data
    ```

5. **Build assets**

    ```bash
    npm run build
    # or for development with hot reload:
    npm run dev
    ```

6. **Start the server**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` in your browser.

## Pricing Tier System (NEW)

The platform now includes a Fiverr-style tiered pricing system allowing handymen to offer multiple service levels:

### Database Schema

```sql
CREATE TABLE gig_tiers (
    id BIGINT PRIMARY KEY,
    id_gig BIGINT FOREIGN KEY -> gigs(id_gig),
    tier_name ENUM('BASIC', 'MEDIUM', 'PREMIUM'),
    description TEXT,
    base_price DECIMAL(10, 2),
    delivery_days INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP,
    UNIQUE(id_gig, tier_name)
);
```

### API Endpoints

#### Get Tiers for a Gig

```
GET /api/gigs/{gig_id}/tiers
```

Response: Returns all pricing tiers for the specified gig.

#### Create Tier

```
POST /api/tiers
Body: {
    "id_gig": 1,
    "tier_name": "BASIC",
    "description": "Check small problems",
    "base_price": 50.00,
    "delivery_days": 3
}
```

#### Update Tier

```
PUT /api/tiers/{tier_id}
Body: {
    "description": "Updated description",
    "base_price": 75.00,
    "delivery_days": 2
}
```

#### Delete Tier

```
DELETE /api/tiers/{tier_id}
```

### Frontend Integration

#### Gig Detail Page

-   Displays all three pricing tiers in a responsive 3-column grid
-   Shows tier description, price, and delivery timeframe
-   Customers can select their preferred tier when creating an order

#### Handyman Dashboard

-   Quick summary of all pricing tiers for each gig
-   Shows prices and delivery times at a glance
-   Links to edit tier information

#### Gig Edit Form

-   Full tier management interface
-   Edit descriptions, prices, and delivery times for each tier
-   Add/remove tiers as needed
-   Form validation ensures data integrity

### Example Pricing Structure

**Electrical Installation Service**

-   **BASIC** ($50 / 3 days): Check electrical outlets and switches, identify issues
-   **MEDIUM** ($150 / 7 days): Install lights and outlets in apartment, ensure proper wiring
-   **PREMIUM** ($500 / 14 days): Full electrical work including rewiring entire house, install complex systems

## API Documentation

Complete API documentation is available in [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

Testing commands and examples are in [API_TESTING_COMMANDS.md](API_TESTING_COMMANDS.md)

## Database Models

### Key Relationships

```
User (1) ──→ (Many) Handyman
User (1) ──→ (Many) Order
Handyman (1) ──→ (Many) Gig
Gig (1) ──→ (Many) GigTier ✨ NEW
Gig (1) ──→ (Many) Order
Order (1) ──→ (Many) Review
User (1) ──→ (Many) Message
User (1) ──→ (Many) Notification
Gig (Many) ──→ (Many) Category
```

## Configuration Files

-   `.env` - Environment variables
-   `config/app.php` - Application configuration
-   `config/database.php` - Database configuration
-   `config/auth.php` - Authentication configuration
-   `vite.config.js` - Asset bundling configuration

## Testing

Run tests with:

```bash
php artisan test
```

Test specific pricing tier functionality:

```bash
php test-tiers.php
```

## Troubleshooting

### Common Issues

1. **Database Connection Error**

    - Check `.env` database credentials
    - Ensure database server is running
    - Run: `php artisan migrate:refresh --seed`

2. **Missing Assets**

    - Run: `npm run build`
    - Clear cache: `php artisan view:clear`

3. **Tier Data Not Showing**
    - Run: `php artisan db:seed --class=GigTierSeeder`
    - Check gig_tiers table in database

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Code Standards

-   Follow PSR-12 coding standards for PHP
-   Use meaningful variable and function names
-   Write clean, documented code
-   Add tests for new features
-   Keep methods focused and single-responsibility

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For issues, questions, or suggestions, please open an issue on GitHub or contact the development team.

## Changelog

### Version 1.1.0 (January 2026)

-   **NEW**: Fiverr-style tiered pricing system
-   **NEW**: GigTier model and database schema
-   **NEW**: Pricing tier API endpoints (9 endpoints total)
-   **NEW**: Tier management interface in handyman dashboard
-   **NEW**: Professional tier display on gig detail pages
-   **IMPROVED**: Enhanced gig management functionality
-   **IMPROVED**: Better responsive design across all views

### Version 1.0.0 (Initial Release)

-   Core platform features
-   User authentication and authorization
-   Service listings and search
-   Booking and order management
-   Messaging system
-   Review and rating system

---

**MOQAF** - Connecting skilled handymen with customers who need them. Professional. Reliable. Affordable.
