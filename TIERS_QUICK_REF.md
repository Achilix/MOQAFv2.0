# Pricing Tiers - Quick Reference Card

## 🎯 What's New

Handymen can now offer services with **3 pricing tiers** (BASIC, MEDIUM, PREMIUM) - just like Fiverr!

## 📦 Installation

```bash
# Run the migration to create gig_tiers table
php artisan migrate
```

## 🔌 API Endpoints Quick List

```
POST   /api/v1/gigs                    Create gig with tiers
GET    /api/v1/gigs                    List gigs with tiers
GET    /api/v1/gigs/{id}               Get gig with tiers
GET    /api/v1/gigs/{gigId}/tiers      Get only tiers
POST   /api/v1/tiers                   Add tier to gig
PUT    /api/v1/tiers/{id}              Update tier
DELETE /api/v1/tiers/{id}              Delete tier
PUT    /api/v1/gigs/{id}               Update gig & tiers
GET    /api/v1/my-gigs                 Get my gigs with tiers
```

## 💡 Quick Example: Create Gig with 3 Tiers

```bash
curl -X POST http://localhost:8000/api/v1/gigs \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Light Installation",
    "type": "installation",
    "description": "Professional light installation",
    "tiers": [
      {
        "tier_name": "BASIC",
        "description": "Check small problems",
        "base_price": 25,
        "delivery_days": 1
      },
      {
        "tier_name": "MEDIUM",
        "description": "Install lights in apartment",
        "base_price": 60,
        "delivery_days": 2
      },
      {
        "tier_name": "PREMIUM",
        "description": "Full house installation",
        "base_price": 200,
        "delivery_days": 4
      }
    ]
  }'
```

## 📊 Three Tier Model

| Tier        | Use Case                              | Price Range | Delivery  |
| ----------- | ------------------------------------- | ----------- | --------- |
| **BASIC**   | Diagnosis, small fixes, consultations | $20-50      | 1 day     |
| **MEDIUM**  | Standard work, single room/item       | $50-150     | 2-3 days  |
| **PREMIUM** | Complex work, full projects, houses   | $150-500+   | 3-5+ days |

## ✅ Validation Rules

```
Tier Name:      BASIC | MEDIUM | PREMIUM (required)
Description:    String, required, max 500 chars
Price:          Decimal, required, min $0.01
Delivery Days:  Integer, required, min 1 day
Uniqueness:     Only 1 tier per name per gig
Minimum:        Gig must have at least 1 tier
```

## 🔐 Authorization

-   **Create/Update/Delete**: Only gig creator can manage their tiers
-   **View**: Anyone can see gig tiers (public)

## 📋 Response Example

```json
{
    "id_gig": 1,
    "title": "Light Installation",
    "tiers": [
        {
            "id": 1,
            "tier_name": "BASIC",
            "description": "Check small problems",
            "base_price": "25.00",
            "delivery_days": 1
        },
        {
            "id": 2,
            "tier_name": "MEDIUM",
            "description": "Install lights in apartment",
            "base_price": "60.00",
            "delivery_days": 2
        },
        {
            "id": 3,
            "tier_name": "PREMIUM",
            "description": "Full house installation",
            "base_price": "200.00",
            "delivery_days": 4
        }
    ]
}
```

## 🛠️ Common Operations

### Get all gigs with tiers

```bash
GET /api/v1/gigs
```

### Get specific gig with tiers

```bash
GET /api/v1/gigs/5
```

### Update a tier's price

```bash
PUT /api/v1/tiers/2
{ "base_price": 75 }
```

### Add new tier to existing gig

```bash
POST /api/v1/tiers
{
  "id_gig": 5,
  "tier_name": "PREMIUM",
  "description": "Premium service",
  "base_price": 250,
  "delivery_days": 5
}
```

### Delete a tier

```bash
DELETE /api/v1/tiers/1
```

Note: Can't delete if it's the last tier for that gig

### Get only tiers for a gig

```bash
GET /api/v1/gigs/5/tiers
```

## 📁 Files Created

-   `app/Models/GigTier.php` - Model
-   `app/Http/Controllers/Api/TierController.php` - Controller
-   `database/migrations/2026_01_03_000010_create_gig_tiers_table.php` - Migration
-   `PRICING_TIERS_GUIDE.md` - Full documentation
-   `TIERS_API_EXAMPLES.md` - 10 example requests/responses
-   `IMPLEMENTATION_TIERS.md` - Setup & implementation guide

## 📚 Documentation Links

-   Full API Reference: [PRICING_TIERS_GUIDE.md](PRICING_TIERS_GUIDE.md)
-   Example Requests: [TIERS_API_EXAMPLES.md](TIERS_API_EXAMPLES.md)
-   Implementation Guide: [IMPLEMENTATION_TIERS.md](IMPLEMENTATION_TIERS.md)
-   Summary: [TIERS_IMPLEMENTATION_SUMMARY.md](TIERS_IMPLEMENTATION_SUMMARY.md)

## ⚡ Key Benefits

✅ Clear pricing structure for clients  
✅ Flexible pricing per tier  
✅ Estimated delivery times per tier  
✅ Easy to update/manage  
✅ Fiverr-style user experience  
✅ Full authorization & validation  
✅ Database integrity with constraints

## 🚀 Next Steps

1. Run migration: `php artisan migrate`
2. Test endpoints with curl or Postman
3. Update frontend to show tiers
4. Integrate tier selection with orders
5. Add price filtering to search

---

**Ready to use!** 🎉 Just run the migration and start creating gigs with pricing tiers.
