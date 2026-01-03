# Pricing Tiers - API Testing Examples

## Example 1: Create a Light Installation Gig with 3 Tiers

### Request

```bash
POST /api/v1/gigs
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Professional Light Installation Service",
  "type": "electrical",
  "description": "Expert light fixture installation and electrical work with 10+ years experience",
  "photos": [
    "https://example.com/light1.jpg",
    "https://example.com/light2.jpg"
  ],
  "tiers": [
    {
      "tier_name": "BASIC",
      "description": "Diagnose light problems, check fixtures, provide recommendations",
      "base_price": 25.00,
      "delivery_days": 1
    },
    {
      "tier_name": "MEDIUM",
      "description": "Install lights in apartment room, fix existing installation",
      "base_price": 60.00,
      "delivery_days": 2
    },
    {
      "tier_name": "PREMIUM",
      "description": "Complete house light installation with design consultation",
      "base_price": 200.00,
      "delivery_days": 4
    }
  ]
}
```

### Response (201 Created)

```json
{
    "message": "Gig created successfully with pricing tiers",
    "data": {
        "id_gig": 5,
        "title": "Professional Light Installation Service",
        "type": "electrical",
        "description": "Expert light fixture installation and electrical work with 10+ years experience",
        "photos": [
            "https://example.com/light1.jpg",
            "https://example.com/light2.jpg"
        ],
        "created_at": "2026-01-03T14:30:00Z",
        "tiers": [
            {
                "id": 1,
                "id_gig": 5,
                "tier_name": "BASIC",
                "description": "Diagnose light problems, check fixtures, provide recommendations",
                "base_price": "25.00",
                "delivery_days": 1,
                "created_at": "2026-01-03T14:30:00Z"
            },
            {
                "id": 2,
                "id_gig": 5,
                "tier_name": "MEDIUM",
                "description": "Install lights in apartment room, fix existing installation",
                "base_price": "60.00",
                "delivery_days": 2,
                "created_at": "2026-01-03T14:30:00Z"
            },
            {
                "id": 3,
                "id_gig": 5,
                "tier_name": "PREMIUM",
                "description": "Complete house light installation with design consultation",
                "base_price": "200.00",
                "delivery_days": 4,
                "created_at": "2026-01-03T14:30:00Z"
            }
        ]
    }
}
```

---

## Example 2: Get Gig with All Tiers

### Request

```bash
GET /api/v1/gigs/5
Authorization: Bearer {token}
```

### Response (200 OK)

```json
{
    "data": {
        "id_gig": 5,
        "title": "Professional Light Installation Service",
        "type": "electrical",
        "description": "Expert light fixture installation and electrical work with 10+ years experience",
        "photos": [
            "https://example.com/light1.jpg",
            "https://example.com/light2.jpg"
        ],
        "created_at": "2026-01-03T14:30:00Z",
        "handymen": [
            {
                "handyman_id": 3,
                "name": "John Electrician",
                "rating": 4.8,
                "reviews_count": 45
            }
        ],
        "tiers": [
            {
                "id": 1,
                "id_gig": 5,
                "tier_name": "BASIC",
                "description": "Diagnose light problems, check fixtures, provide recommendations",
                "base_price": "25.00",
                "delivery_days": 1,
                "created_at": "2026-01-03T14:30:00Z"
            },
            {
                "id": 2,
                "id_gig": 5,
                "tier_name": "MEDIUM",
                "description": "Install lights in apartment room, fix existing installation",
                "base_price": "60.00",
                "delivery_days": 2,
                "created_at": "2026-01-03T14:30:00Z"
            },
            {
                "id": 3,
                "id_gig": 5,
                "tier_name": "PREMIUM",
                "description": "Complete house light installation with design consultation",
                "base_price": "200.00",
                "delivery_days": 4,
                "created_at": "2026-01-03T14:30:00Z"
            }
        ]
    }
}
```

---

## Example 3: Update a Single Tier's Price

### Request

```bash
PUT /api/v1/tiers/2
Authorization: Bearer {token}
Content-Type: application/json

{
  "base_price": 75.00,
  "delivery_days": 2
}
```

### Response (200 OK)

```json
{
    "message": "Tier updated successfully",
    "data": {
        "id": 2,
        "id_gig": 5,
        "tier_name": "MEDIUM",
        "description": "Install lights in apartment room, fix existing installation",
        "base_price": "75.00",
        "delivery_days": 2,
        "created_at": "2026-01-03T14:30:00Z",
        "updated_at": "2026-01-03T15:00:00Z"
    }
}
```

---

## Example 4: Add New Tier to Existing Gig

### Request

```bash
POST /api/v1/tiers
Authorization: Bearer {token}
Content-Type: application/json

{
  "id_gig": 5,
  "tier_name": "PREMIUM",
  "description": "Extended service with warranty included",
  "base_price": 250.00,
  "delivery_days": 5
}
```

### Response (201 Created)

```json
{
    "message": "Tier created successfully",
    "data": {
        "id": 4,
        "id_gig": 5,
        "tier_name": "PREMIUM",
        "description": "Extended service with warranty included",
        "base_price": "250.00",
        "delivery_days": 5,
        "created_at": "2026-01-03T15:15:00Z"
    }
}
```

---

## Example 5: Delete a Tier

### Request

```bash
DELETE /api/v1/tiers/1
Authorization: Bearer {token}
```

### Response (200 OK)

```json
{
    "message": "Tier deleted successfully"
}
```

---

## Example 6: Error - Duplicate Tier Name

### Request

```bash
POST /api/v1/tiers
Authorization: Bearer {token}
Content-Type: application/json

{
  "id_gig": 5,
  "tier_name": "BASIC",
  "description": "Another basic tier",
  "base_price": 20.00,
  "delivery_days": 1
}
```

### Response (422 Unprocessable Entity)

```json
{
    "message": "This tier already exists for this gig"
}
```

---

## Example 7: Error - Trying to Delete Last Tier

### Request

```bash
DELETE /api/v1/tiers/1
Authorization: Bearer {token}
```

(When gig only has 1 tier remaining)

### Response (422 Unprocessable Entity)

```json
{
    "message": "A gig must have at least one pricing tier"
}
```

---

## Example 8: Error - Unauthorized Update

### Request

```bash
PUT /api/v1/gigs/5
Authorization: Bearer {different_user_token}
Content-Type: application/json

{
  "title": "Updated title"
}
```

### Response (403 Forbidden)

```json
{
    "message": "Unauthorized"
}
```

---

## Example 9: Update Gig with All New Tiers

### Request

```bash
PUT /api/v1/gigs/5
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Updated Light Installation Service",
  "tiers": [
    {
      "tier_name": "BASIC",
      "description": "Quick consultation and problem assessment",
      "base_price": 20.00,
      "delivery_days": 1
    },
    {
      "tier_name": "MEDIUM",
      "description": "Single room installation with materials",
      "base_price": 85.00,
      "delivery_days": 2
    },
    {
      "tier_name": "PREMIUM",
      "description": "Full house installation with 2-year warranty",
      "base_price": 350.00,
      "delivery_days": 5
    }
  ]
}
```

### Response (200 OK)

```json
{
  "message": "Gig updated successfully",
  "data": {
    "id_gig": 5,
    "title": "Updated Light Installation Service",
    "type": "electrical",
    "description": "Expert light fixture installation and electrical work with 10+ years experience",
    "photos": [...],
    "created_at": "2026-01-03T14:30:00Z",
    "updated_at": "2026-01-03T16:00:00Z",
    "tiers": [
      {
        "id": 5,
        "id_gig": 5,
        "tier_name": "BASIC",
        "description": "Quick consultation and problem assessment",
        "base_price": "20.00",
        "delivery_days": 1,
        "created_at": "2026-01-03T16:00:00Z"
      },
      {
        "id": 6,
        "id_gig": 5,
        "tier_name": "MEDIUM",
        "description": "Single room installation with materials",
        "base_price": "85.00",
        "delivery_days": 2,
        "created_at": "2026-01-03T16:00:00Z"
      },
      {
        "id": 7,
        "id_gig": 5,
        "tier_name": "PREMIUM",
        "description": "Full house installation with 2-year warranty",
        "base_price": "350.00",
        "delivery_days": 5,
        "created_at": "2026-01-03T16:00:00Z"
      }
    ]
  }
}
```

---

## Example 10: Get All Handyman's Gigs with Tiers

### Request

```bash
GET /api/v1/my-gigs
Authorization: Bearer {token}
```

### Response (200 OK)

```json
{
    "data": [
        {
            "id_gig": 5,
            "title": "Professional Light Installation Service",
            "type": "electrical",
            "description": "Expert light fixture installation...",
            "created_at": "2026-01-03T14:30:00Z",
            "tiers": [
                {
                    "id": 5,
                    "id_gig": 5,
                    "tier_name": "BASIC",
                    "description": "Quick consultation and problem assessment",
                    "base_price": "20.00",
                    "delivery_days": 1
                },
                {
                    "id": 6,
                    "id_gig": 5,
                    "tier_name": "MEDIUM",
                    "description": "Single room installation with materials",
                    "base_price": "85.00",
                    "delivery_days": 2
                },
                {
                    "id": 7,
                    "id_gig": 5,
                    "tier_name": "PREMIUM",
                    "description": "Full house installation with 2-year warranty",
                    "base_price": "350.00",
                    "delivery_days": 5
                }
            ]
        },
        {
            "id_gig": 6,
            "title": "Plumbing Services",
            "type": "plumbing",
            "description": "Professional plumbing work...",
            "created_at": "2026-01-02T10:00:00Z",
            "tiers": [
                {
                    "id": 8,
                    "id_gig": 6,
                    "tier_name": "BASIC",
                    "description": "Fix leaks and small repairs",
                    "base_price": "30.00",
                    "delivery_days": 1
                }
            ]
        }
    ],
    "pagination": {
        "total": 2,
        "per_page": 15,
        "current_page": 1,
        "last_page": 1
    }
}
```

---

## Testing Checklist

-   [ ] Create gig with 3 tiers
-   [ ] Get gig with tiers included
-   [ ] Get only tiers for a gig
-   [ ] Update single tier price
-   [ ] Add new tier to gig
-   [ ] Delete tier from gig
-   [ ] Update gig with new tiers
-   [ ] Error: Duplicate tier name
-   [ ] Error: Delete last remaining tier
-   [ ] Error: Unauthorized access
-   [ ] Get my gigs with tiers
-   [ ] Verify database records created correctly
