# 🧪 Quick API Testing Commands

## 1. Login and Get Token

```bash
# Login as Client
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "sarah0@example.com",
    "password": "password123"
  }'

# Login as Handyman
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "ahmed0@handyman.com",
    "password": "password123"
  }'
```

**Save the `access_token` from response!**

---

## 2. Browse Categories (Public)

```bash
# Get all categories
curl http://localhost:8000/api/v1/categories

# Get popular categories
curl http://localhost:8000/api/v1/categories/popular

# Get specific category (ID 1)
curl http://localhost:8000/api/v1/categories/1
```

---

## 3. Browse Gigs (Public)

```bash
# Get all gigs
curl http://localhost:8000/api/v1/gigs

# Get specific gig
curl http://localhost:8000/api/v1/gigs/1
```

---

## 4. View Reviews (Public)

```bash
# Get handyman reviews (handyman_id = 15)
curl http://localhost:8000/api/v1/handymen/15/reviews

# Shows average rating and all reviews with comments
```

---

## 5. Favorites (Protected - Need Token)

```bash
# Set your token
TOKEN="YOUR_ACCESS_TOKEN_HERE"

# Get all favorites
curl http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer $TOKEN"

# Add gig to favorites
curl -X POST http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "gig",
    "id": 1
  }'

# Check if favorited
curl "http://localhost:8000/api/v1/favorites/check?type=gig&id=1" \
  -H "Authorization: Bearer $TOKEN"

# Remove from favorites
curl -X DELETE http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "gig",
    "id": 1
  }'
```

---

## 6. Notifications (Protected)

```bash
TOKEN="YOUR_ACCESS_TOKEN_HERE"

# Get all notifications
curl http://localhost:8000/api/v1/notifications \
  -H "Authorization: Bearer $TOKEN"

# Get unread count
curl http://localhost:8000/api/v1/notifications/unread-count \
  -H "Authorization: Bearer $TOKEN"

# Get only unread notifications
curl "http://localhost:8000/api/v1/notifications?unread_only=true" \
  -H "Authorization: Bearer $TOKEN"

# Mark notification as read (ID 1)
curl -X POST http://localhost:8000/api/v1/notifications/1/read \
  -H "Authorization: Bearer $TOKEN"

# Mark all as read
curl -X POST http://localhost:8000/api/v1/notifications/read-all \
  -H "Authorization: Bearer $TOKEN"

# Delete notification
curl -X DELETE http://localhost:8000/api/v1/notifications/1 \
  -H "Authorization: Bearer $TOKEN"
```

---

## 7. Reviews (Protected)

```bash
TOKEN="YOUR_ACCESS_TOKEN_HERE"

# Create a review (must have completed order)
curl -X POST http://localhost:8000/api/v1/reviews \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": 1,
    "rating": 5,
    "comment": "Excellent service! Very professional."
  }'

# Respond to review (handyman only, review_id = 1)
curl -X POST http://localhost:8000/api/v1/reviews/1/respond \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "response": "Thank you for your kind words!"
  }'
```

---

## 8. User Profile (Protected)

```bash
TOKEN="YOUR_ACCESS_TOKEN_HERE"

# Get current user
curl http://localhost:8000/api/v1/user \
  -H "Authorization: Bearer $TOKEN"

# Get countries
curl http://localhost:8000/api/v1/countries

# Get cities for country (country_id = 1)
curl http://localhost:8000/api/v1/cities/1
```

---

## 9. Orders (Protected)

```bash
TOKEN="YOUR_ACCESS_TOKEN_HERE"

# Get my orders
curl http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer $TOKEN"

# Get specific order
curl http://localhost:8000/api/v1/orders/1 \
  -H "Authorization: Bearer $TOKEN"
```

---

## 10. Postman Collection

### Quick Import for Postman

Create a new Postman collection with these variables:

-   `base_url`: `http://localhost:8000/api/v1`
-   `token`: (set after login)

### Example Requests:

1. **POST** `{{base_url}}/auth/login`
2. **GET** `{{base_url}}/categories`
3. **GET** `{{base_url}}/gigs`
4. **GET** `{{base_url}}/handymen/15/reviews`
5. **GET** `{{base_url}}/favorites` (with Bearer {{token}})
6. **GET** `{{base_url}}/notifications` (with Bearer {{token}})
7. **GET** `{{base_url}}/notifications/unread-count` (with Bearer {{token}})

---

## 🎯 Testing Flow

### Flow 1: Browse as Guest

```bash
# 1. View categories
curl http://localhost:8000/api/v1/categories

# 2. View popular categories
curl http://localhost:8000/api/v1/categories/popular

# 3. View all gigs
curl http://localhost:8000/api/v1/gigs

# 4. View handyman reviews
curl http://localhost:8000/api/v1/handymen/15/reviews
```

### Flow 2: Client Journey

```bash
# 1. Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "sarah0@example.com", "password": "password123"}'

# Copy the token, then:
TOKEN="PASTE_TOKEN_HERE"

# 2. View profile
curl http://localhost:8000/api/v1/user \
  -H "Authorization: Bearer $TOKEN"

# 3. Add favorite
curl -X POST http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"type": "gig", "id": 1}'

# 4. Check notifications
curl http://localhost:8000/api/v1/notifications \
  -H "Authorization: Bearer $TOKEN"

# 5. View orders
curl http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer $TOKEN"
```

### Flow 3: Handyman Journey

```bash
# 1. Login as handyman
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "ahmed0@handyman.com", "password": "password123"}'

TOKEN="PASTE_TOKEN_HERE"

# 2. View my gigs
curl http://localhost:8000/api/v1/my-gigs \
  -H "Authorization: Bearer $TOKEN"

# 3. View orders
curl http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer $TOKEN"

# 4. Check reviews
curl http://localhost:8000/api/v1/handymen/15/reviews
```

---

## 📊 Expected Responses

### Successful Login

```json
{
    "message": "Login successful",
    "access_token": "1|abc123...",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "fname": "Sarah",
        "lname": "Ahmed",
        "email": "sarah0@example.com",
        "is_handyman": false,
        "is_client": true
    }
}
```

### Categories Response

```json
{
    "categories": [
        {
            "id": 1,
            "name": "Home Repair",
            "slug": "home-repair",
            "icon": "🏠",
            "children": [
                {
                    "id": 2,
                    "name": "Plumbing",
                    "slug": "plumbing",
                    "icon": "🔧"
                }
            ]
        }
    ]
}
```

### Reviews Response

```json
{
    "reviews": {
        "data": [
            {
                "id": 1,
                "rating": 5,
                "comment": "Excellent work!",
                "response": "Thank you!",
                "client": {
                    "fname": "Sarah",
                    "lname": "Ahmed"
                }
            }
        ]
    },
    "statistics": {
        "average_rating": 4.8,
        "total_reviews": 5
    }
}
```

---

## 🔐 Authentication Header

For all protected endpoints, include:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 🐛 Troubleshooting

### 401 Unauthorized

-   Token expired or invalid
-   Login again to get new token

### 404 Not Found

-   Check the ID exists in database
-   Verify endpoint URL

### 400 Bad Request

-   Check request body format
-   Ensure required fields are included

### 429 Too Many Requests

-   You've exceeded rate limit
-   Wait 60 seconds and try again

---

Happy Testing! 🚀
