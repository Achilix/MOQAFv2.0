# Handyman Pricing Tiers Feature

## Overview

This feature allows handymen to offer services with tiered pricing, similar to Fiverr's model. Each gig can have up to 3 pricing tiers:

-   **BASIC**: Small/simple problems with lowest price
-   **MEDIUM**: Standard installations/moderate work
-   **PREMIUM**: Full installations/complex projects with highest price

## Database Structure

### gig_tiers Table

```sql
- id (Primary Key)
- id_gig (Foreign Key to gigs table)
- tier_name (ENUM: BASIC, MEDIUM, PREMIUM)
- description (Text)
- base_price (Decimal 10,2)
- delivery_days (Integer)
- created_at (Timestamp)
```

## API Endpoints

### 1. Create a Gig with Pricing Tiers

**POST** `/api/v1/gigs`

**Request:**

```json
{
    "title": "Light Installation Service",
    "type": "installation",
    "description": "Professional light installation service",
    "photos": ["url1", "url2"],
    "tiers": [
        {
            "tier_name": "BASIC",
            "description": "Check and diagnose small problems",
            "base_price": 25.0,
            "delivery_days": 1
        },
        {
            "tier_name": "MEDIUM",
            "description": "Install lights in one room/apartment",
            "base_price": 50.0,
            "delivery_days": 2
        },
        {
            "tier_name": "PREMIUM",
            "description": "Complete house light installation",
            "base_price": 150.0,
            "delivery_days": 3
        }
    ]
}
```

**Response:**

```json
{
    "message": "Gig created successfully with pricing tiers",
    "data": {
        "id_gig": 1,
        "title": "Light Installation Service",
        "type": "installation",
        "description": "Professional light installation service",
        "photos": ["url1", "url2"],
        "created_at": "2026-01-03T10:00:00Z",
        "tiers": [
            {
                "id": 1,
                "id_gig": 1,
                "tier_name": "BASIC",
                "description": "Check and diagnose small problems",
                "base_price": "25.00",
                "delivery_days": 1,
                "created_at": "2026-01-03T10:00:00Z"
            },
            {
                "id": 2,
                "id_gig": 1,
                "tier_name": "MEDIUM",
                "description": "Install lights in one room/apartment",
                "base_price": "50.00",
                "delivery_days": 2,
                "created_at": "2026-01-03T10:00:00Z"
            },
            {
                "id": 3,
                "id_gig": 1,
                "tier_name": "PREMIUM",
                "description": "Complete house light installation",
                "base_price": "150.00",
                "delivery_days": 3,
                "created_at": "2026-01-03T10:00:00Z"
            }
        ]
    }
}
```

### 2. Get All Gigs with Tiers

**GET** `/api/v1/gigs`

Returns all gigs with their pricing tiers included.

### 3. Get a Specific Gig with Tiers

**GET** `/api/v1/gigs/{gigId}`

Returns a single gig with all its pricing tiers.

### 4. Get Tiers for a Specific Gig

**GET** `/api/v1/gigs/{gigId}/tiers`

Returns only the pricing tiers for a gig.

### 5. Create a New Tier for Existing Gig

**POST** `/api/v1/tiers`

**Request:**

```json
{
    "id_gig": 1,
    "tier_name": "BASIC",
    "description": "Small problem diagnosis",
    "base_price": 30.0,
    "delivery_days": 1
}
```

**Notes:**

-   A gig cannot have duplicate tier names (BASIC, MEDIUM, PREMIUM)
-   Returns 422 error if tier already exists

### 6. Update a Pricing Tier

**PUT** `/api/v1/tiers/{tierId}`

**Request:**

```json
{
    "description": "Updated description",
    "base_price": 35.0,
    "delivery_days": 2
}
```

### 7. Delete a Pricing Tier

**DELETE** `/api/v1/tiers/{tierId}`

**Notes:**

-   A gig must have at least one pricing tier
-   Cannot delete if it's the last remaining tier
-   Returns 422 error if attempting to delete the last tier

### 8. Update Gig with New Tiers

**PUT** `/api/v1/gigs/{gigId}`

**Request:**

```json
{
    "title": "Updated Title",
    "tiers": [
        {
            "tier_name": "BASIC",
            "description": "New basic tier",
            "base_price": 20.0,
            "delivery_days": 1
        },
        {
            "tier_name": "PREMIUM",
            "description": "New premium tier",
            "base_price": 200.0,
            "delivery_days": 4
        }
    ]
}
```

**Notes:**

-   When updating tiers, all old tiers are replaced with new ones
-   Title and other fields can be updated separately from tiers

### 9. Get My Gigs (Handyman)

**GET** `/api/v1/my-gigs`

Returns all gigs created by the authenticated handyman with their pricing tiers.

## Model Structure

### Gig Model

```php
// Relationships
public function tiers(): HasMany
{
    return $this->hasMany(GigTier::class, 'id_gig', 'id_gig');
}
```

### GigTier Model

```php
// Relationships
public function gig(): BelongsTo
{
    return $this->belongsTo(Gig::class, 'id_gig', 'id_gig');
}
```

## Validation Rules

### When Creating a Gig

```
tiers: required|array|min:1
tiers.*.tier_name: required|in:BASIC,MEDIUM,PREMIUM
tiers.*.description: required|string
tiers.*.base_price: required|numeric|min:0
tiers.*.delivery_days: required|integer|min:1
```

### When Updating a Tier

```
tier_name: sometimes|in:BASIC,MEDIUM,PREMIUM
description: sometimes|string|max:500
base_price: sometimes|numeric|min:0.01
delivery_days: sometimes|integer|min:1
```

## Frontend Integration Examples

### Vue.js Example

```javascript
// Create a gig with tiers
async function createGigWithTiers() {
    const response = await fetch("/api/v1/gigs", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            title: "Light Installation",
            type: "installation",
            description: "Professional light installation",
            tiers: [
                {
                    tier_name: "BASIC",
                    description: "Problem diagnosis",
                    base_price: 25,
                    delivery_days: 1,
                },
                {
                    tier_name: "MEDIUM",
                    description: "Room installation",
                    base_price: 50,
                    delivery_days: 2,
                },
            ],
        }),
    });

    const gig = await response.json();
    return gig.data;
}

// Display tiers
function displayTiers(gig) {
    return gig.tiers.map((tier) => ({
        name: tier.tier_name,
        price: `$${tier.base_price}`,
        days: `${tier.delivery_days} days`,
        description: tier.description,
    }));
}
```

## Use Cases

1. **Handyman Creating Service Offerings:**

    - Define what they can do at each price level
    - Set realistic delivery times for each tier
    - Showcase range of services

2. **Client Selecting Service:**

    - Choose based on budget and needs
    - See clear scope of work at each tier
    - Know estimated delivery time

3. **Order Management:**
    - Orders will reference the selected tier
    - Pricing is locked at time of order creation
    - Tier info helps set client expectations

## Notes for Implementation

-   Each gig must have at least one tier when created
-   Tier names (BASIC, MEDIUM, PREMIUM) provide clear user experience
-   Prices are decimal(10,2) to handle cents
-   Delivery days guide client expectations
-   Soft deletes on GigTier table for data integrity
