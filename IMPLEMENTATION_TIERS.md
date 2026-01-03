# Handyman Pricing Tiers - Implementation Guide

## What Was Added

### New Files Created:

1. **[app/Models/GigTier.php](app/Models/GigTier.php)** - Model for pricing tiers
2. **[app/Http/Controllers/Api/TierController.php](app/Http/Controllers/Api/TierController.php)** - Controller for tier management
3. **[database/migrations/2026_01_03_000010_create_gig_tiers_table.php](database/migrations/2026_01_03_000010_create_gig_tiers_table.php)** - Database migration
4. **[PRICING_TIERS_GUIDE.md](PRICING_TIERS_GUIDE.md)** - Complete API documentation

### Files Modified:

1. **[app/Models/Gig.php](app/Models/Gig.php)** - Added `tiers()` relationship
2. **[app/Http/Controllers/Api/GigController.php](app/Http/Controllers/Api/GigController.php)** - Updated to handle tier creation/updates
3. **[routes/api.php](routes/api.php)** - Added tier management routes

## How to Implement

### Step 1: Run Database Migration

```bash
php artisan migrate
```

This creates the `gig_tiers` table with the following structure:

-   Stores pricing tiers (BASIC, MEDIUM, PREMIUM) for each gig
-   Each tier has a description, base price, and delivery days
-   Unique constraint ensures only one tier per name per gig

### Step 2: Verify Models and Controllers

The GigTier model and TierController are already in place with:

-   Full CRUD operations for tiers
-   Authorization checks
-   Validation
-   Error handling

### Step 3: Test the API

#### Example 1: Create a Gig with Pricing Tiers

```bash
curl -X POST http://localhost:8000/api/v1/gigs \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Plumbing Services",
    "type": "plumbing",
    "description": "Professional plumbing repairs and installations",
    "tiers": [
      {
        "tier_name": "BASIC",
        "description": "Fix leaks and small problems",
        "base_price": 30,
        "delivery_days": 1
      },
      {
        "tier_name": "MEDIUM",
        "description": "Install fixtures in one bathroom",
        "base_price": 75,
        "delivery_days": 2
      },
      {
        "tier_name": "PREMIUM",
        "description": "Full house plumbing system installation",
        "base_price": 250,
        "delivery_days": 5
      }
    ]
  }'
```

#### Example 2: Get a Gig with Its Tiers

```bash
curl -X GET http://localhost:8000/api/v1/gigs/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Example 3: Update a Tier

```bash
curl -X PUT http://localhost:8000/api/v1/tiers/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "base_price": 35,
    "delivery_days": 2
  }'
```

#### Example 4: Create Additional Tier

```bash
curl -X POST http://localhost:8000/api/v1/tiers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "id_gig": 1,
    "tier_name": "PREMIUM",
    "description": "Complete renovation",
    "base_price": 500,
    "delivery_days": 7
  }'
```

## Key Features

✅ **Three-Tier Model** (Like Fiverr):

-   BASIC: Small/simple work with lower price
-   MEDIUM: Standard/moderate work
-   PREMIUM: Complex/full-scope work with higher price

✅ **Flexible Pricing**:

-   Set different prices for each tier
-   Adjust delivery times per tier
-   Update prices anytime

✅ **Authorization**:

-   Only gig creators can manage their tiers
-   Authorization checks on all operations

✅ **Data Validation**:

-   Tier names must be one of: BASIC, MEDIUM, PREMIUM
-   At least one tier required per gig
-   Unique tier per gig constraint

✅ **Soft Deletes**:

-   Tiers are soft-deleted for audit trail
-   Data integrity maintained

## API Endpoints Summary

| Method | Endpoint                     | Description                 |
| ------ | ---------------------------- | --------------------------- |
| POST   | `/api/v1/gigs`               | Create gig with tiers       |
| GET    | `/api/v1/gigs`               | List all gigs with tiers    |
| GET    | `/api/v1/gigs/{id}`          | Get specific gig with tiers |
| GET    | `/api/v1/gigs/{gigId}/tiers` | Get tiers for a gig         |
| POST   | `/api/v1/tiers`              | Create new tier             |
| PUT    | `/api/v1/tiers/{id}`         | Update tier                 |
| DELETE | `/api/v1/tiers/{id}`         | Delete tier                 |
| PUT    | `/api/v1/gigs/{id}`          | Update gig & tiers          |
| GET    | `/api/v1/my-gigs`            | Get user's gigs with tiers  |

## Database Schema

```sql
CREATE TABLE gig_tiers (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_gig BIGINT UNSIGNED NOT NULL,
  tier_name ENUM('BASIC', 'MEDIUM', 'PREMIUM') DEFAULT 'BASIC',
  description TEXT,
  base_price DECIMAL(10, 2),
  delivery_days INT DEFAULT 1,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL,

  CONSTRAINT fk_gig_tiers_gigs FOREIGN KEY (id_gig)
    REFERENCES gigs(id_gig) ON DELETE CASCADE,

  UNIQUE KEY unique_gig_tier (id_gig, tier_name)
);
```

## Next Steps

1. **Run the migration**: `php artisan migrate`
2. **Test the endpoints** with the provided curl examples
3. **Update frontend** to display and allow selection of tiers when:
    - Creating gigs
    - Browsing gigs
    - Placing orders
4. **Integrate with Orders**: Update order creation to select a tier and lock in that tier's price

## Notes

-   When updating a gig's tiers, all existing tiers are replaced with new ones
-   Individual tier updates can be done without affecting other tiers
-   Each gig must have at least one tier at all times
-   Prices are stored as `decimal(10,2)` to handle cents accurately
-   Soft deletes ensure historical data isn't lost
