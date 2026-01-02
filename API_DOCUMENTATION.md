# MOQAF API Documentation

## Base URL

```
http://localhost:8000/api/v1
```

## Authentication

Use Bearer tokens for authenticated endpoints:

```
Authorization: Bearer {access_token}
```

---

## Authentication Endpoints

### Register

**POST** `/auth/register`

Request:

```json
{
    "fname": "John",
    "lname": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone_number": "+966501234567",
    "city_id": 1
}
```

Response:

```json
{
    "message": "Registration successful",
    "access_token": "1|Hdgk5GNnB8VKP...",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "email": "john@example.com",
        "fname": "John",
        "lname": "Doe"
    }
}
```

### Login

**POST** `/auth/login`

Request:

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

Response:

```json
{
    "message": "Login successful",
    "access_token": "1|Hdgk5GNnB8VKP...",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "email": "john@example.com",
        "fname": "John",
        "lname": "Doe",
        "photo": null,
        "is_handyman": true,
        "is_client": false
    }
}
```

### Logout (Protected)

**POST** `/auth/logout`

Headers:

```
Authorization: Bearer {access_token}
```

Response:

```json
{
    "message": "Logout successful"
}
```

---

## User Endpoints (Protected)

### Get Current User

**GET** `/user`

Response:

```json
{
  "data": {
    "id": 1,
    "fname": "John",
    "lname": "Doe",
    "email": "john@example.com",
    "phone_number": "+966501234567",
    "address": "123 Main St",
    "city": 1,
    "photo": "avatars/...",
    "gov_id": "123456789",
    "is_handyman": true,
    "is_client": false,
    "handyman": {...},
    "client": null
  }
}
```

### Update Profile

**PUT** `/user/profile`

Request:

```json
{
    "fname": "John",
    "lname": "Doe",
    "phone_number": "+966501234567",
    "address": "123 Main St",
    "city": 1,
    "gov_id": "123456789"
}
```

### Upload Avatar

**POST** `/user/avatar`

Form Data:

-   `avatar` (file) - Image file

Response:

```json
{
    "message": "Avatar uploaded successfully",
    "photo": "avatars/..."
}
```

### Become Handyman

**POST** `/user/become-handyman`

Request:

```json
{
    "services": ["electrical", "plumbing"],
    "bio": "Expert in home repairs"
}
```

Response:

```json
{
    "message": "You are now a handyman",
    "data": {
        "handyman_id": 1,
        "services": ["electrical", "plumbing"],
        "bio": "Expert in home repairs"
    }
}
```

### Get Handyman Profile

**GET** `/user/handyman-profile`

### Update Handyman Profile

**PUT** `/user/handyman-profile`

Request:

```json
{
    "services": ["electrical", "plumbing", "carpentry"],
    "bio": "Updated bio"
}
```

---

## Gig Endpoints

### List All Gigs (Public)

**GET** `/gigs?search=keyword&type=electrical`

Query Parameters:

-   `search` (optional) - Search in title/description
-   `type` (optional) - Filter by type
-   `page` (optional) - Page number

Response:

```json
{
  "data": [
    {
      "id_gig": 1,
      "title": "Fix Electrical Outlet",
      "type": "electrical",
      "description": "Need to fix broken outlet",
      "photos": ["url1", "url2"],
      "created_at": "2026-01-02T...",
      "handymen": [...]
    }
  ],
  "pagination": {
    "total": 100,
    "per_page": 15,
    "current_page": 1,
    "last_page": 7
  }
}
```

### Get Single Gig (Public)

**GET** `/gigs/{id}`

### Create Gig (Protected - Handyman Only)

**POST** `/gigs`

Request:

```json
{
    "title": "Plumbing Services",
    "type": "plumbing",
    "description": "Professional plumbing repair",
    "photos": ["url1", "url2"]
}
```

### Update Gig (Protected)

**PUT** `/gigs/{id}`

### Delete Gig (Protected)

**DELETE** `/gigs/{id}`

### My Gigs (Protected)

**GET** `/my-gigs`

### Apply to Gig (Protected)

**POST** `/gigs/{id}/apply`

---

## Order Endpoints (Protected)

### List Orders

**GET** `/orders`

Returns orders where user is client or handyman.

### Get Order Details

**GET** `/orders/{id}`

### Create Order

**POST** `/orders`

Request:

```json
{
    "gig_id": 1,
    "handyman_id": 5,
    "budget": 500.0,
    "description": "Additional notes"
}
```

### Update Order

**PUT** `/orders/{id}`

Request:

```json
{
    "budget": 600.0,
    "description": "Updated notes"
}
```

### Accept Order (Handyman)

**POST** `/orders/{id}/accept`

### Reject Order (Handyman)

**POST** `/orders/{id}/reject`

### Complete Order (Handyman)

**POST** `/orders/{id}/complete`

### Cancel Order (Client)

**POST** `/orders/{id}/cancel`

---

## Chat Endpoints (Protected)

### Start Conversation

**POST** `/conversations/start`

Request:

```json
{
    "recipient_id": 5
}
```

### Get All Conversations

**GET** `/conversations`

Response:

```json
{
  "data": [
    {
      "id": 1,
      "user1_id": 1,
      "user2_id": 5,
      "user1": {...},
      "user2": {...},
      "messages": [...]
    }
  ],
  "pagination": {...}
}
```

### Get Conversation Details

**GET** `/conversations/{id}`

### Get Conversation Messages

**GET** `/conversations/{id}/messages`

### Send Message

**POST** `/conversations/{id}/messages`

Request:

```json
{
    "body": "Hello, are you interested?"
}
```

---

## Reference Data (Public)

### Get Countries

**GET** `/countries`

### Get Cities

**GET** `/cities/{country_id}`

### Health Check

**GET** `/health`

Response:

```json
{
    "status": "ok",
    "timestamp": "2026-01-02T10:30:45Z"
}
```

---

## Error Responses

### Validation Error (422)

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### Unauthorized (401)

```json
{
    "message": "Invalid credentials"
}
```

### Forbidden (403)

```json
{
    "message": "Only handymen can create gigs"
}
```

### Not Found (404)

```json
{
    "message": "Resource not found"
}
```

---

## Rate Limiting

API endpoints are rate-limited to prevent abuse:

-   **Public endpoints**: 100 requests per minute
-   **Authentication endpoints**:
    -   Register: 5 requests per minute
    -   Login: 10 requests per minute
-   **Protected endpoints**: 200 requests per minute

Rate limit headers are included in all responses:

-   `X-RateLimit-Limit`: Maximum requests allowed
-   `X-RateLimit-Remaining`: Remaining requests
-   `Retry-After`: Seconds until rate limit resets (when exceeded)

---

## Reviews & Ratings Endpoints

### Get Handyman Reviews (Public)

**GET** `/handymen/{handyman_id}/reviews`

Response:

```json
{
    "reviews": {
        "data": [
            {
                "id": 1,
                "rating": 5,
                "comment": "Excellent work!",
                "response": "Thank you!",
                "response_at": "2026-01-02T10:00:00Z",
                "client": {
                    "id": 1,
                    "fname": "John",
                    "lname": "Doe",
                    "photo": "..."
                },
                "created_at": "2026-01-01T10:00:00Z"
            }
        ]
    },
    "statistics": {
        "average_rating": 4.8,
        "total_reviews": 25
    }
}
```

### Create Review (Protected)

**POST** `/reviews`

Request:

```json
{
    "order_id": 1,
    "rating": 5,
    "comment": "Great service!"
}
```

Response:

```json
{
    "message": "Review submitted successfully.",
    "review": {
        "id": 1,
        "rating": 5,
        "comment": "Great service!",
        "order_id": 1
    }
}
```

### Update Review (Protected)

**PUT** `/reviews/{id}`

Can only update within 24 hours of posting.

### Delete Review (Protected)

**DELETE** `/reviews/{id}`

Can only delete within 24 hours of posting.

### Respond to Review (Protected, Handyman Only)

**POST** `/reviews/{id}/respond`

Request:

```json
{
    "response": "Thank you for your feedback!"
}
```

---

## Categories Endpoints

### Get All Categories (Public)

**GET** `/categories`

Response:

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
                    "slug": "plumbing"
                }
            ]
        }
    ]
}
```

### Get Single Category (Public)

**GET** `/categories/{id}`

Response includes category details and associated gigs.

### Get Popular Categories (Public)

**GET** `/categories/popular`

Returns top 10 categories by gig count.

### Create Category (Protected, Admin)

**POST** `/categories`

Request:

```json
{
    "name": "Electrical Work",
    "description": "All electrical services",
    "icon": "⚡",
    "parent_id": null,
    "order": 1
}
```

### Update Category (Protected, Admin)

**PUT** `/categories/{id}`

### Delete Category (Protected, Admin)

**DELETE** `/categories/{id}`

---

## Notifications Endpoints (Protected)

### Get All Notifications

**GET** `/notifications`

Query Parameters:

-   `unread_only`: boolean
-   `type`: string (order_new, message_new, etc.)

Response:

```json
{
    "notifications": {
        "data": [
            {
                "id": 1,
                "type": "order_new",
                "title": "New Order",
                "message": "You have a new order request",
                "data": { "order_id": 5 },
                "is_read": false,
                "created_at": "2026-01-02T10:00:00Z"
            }
        ]
    },
    "unread_count": 3
}
```

### Get Unread Count

**GET** `/notifications/unread-count`

Response:

```json
{
    "unread_count": 3
}
```

### Mark as Read

**POST** `/notifications/{id}/read`

### Mark All as Read

**POST** `/notifications/read-all`

### Delete Notification

**DELETE** `/notifications/{id}`

### Delete All Read Notifications

**DELETE** `/notifications/read-all`

---

## Favorites Endpoints (Protected)

### Get All Favorites

**GET** `/favorites?type=gig`

Query Parameters:

-   `type`: gig or handyman

Response:

```json
{
    "favorites": {
        "data": [
            {
                "id": 1,
                "type": "App\\Models\\Gig",
                "favoritable_id": 5,
                "item": {
                    "id": 5,
                    "title": "Home Repair",
                    ...
                },
                "created_at": "2026-01-02T10:00:00Z"
            }
        ]
    }
}
```

### Add to Favorites

**POST** `/favorites`

Request:

```json
{
    "type": "gig",
    "id": 5
}
```

### Remove from Favorites

**DELETE** `/favorites`

Request:

```json
{
    "type": "gig",
    "id": 5
}
```

### Check if Favorited

**GET** `/favorites/check?type=gig&id=5`

Response:

```json
{
    "is_favorited": true
}
```

---

## Status Codes

-   `200` - OK
-   `201` - Created
-   `400` - Bad Request
-   `401` - Unauthorized
-   `403` - Forbidden
-   `404` - Not Found
-   `422` - Unprocessable Entity
-   `500` - Server Error

---

## Order Statuses

-   `pending` - Awaiting handyman response
-   `accepted` - Handyman accepted
-   `rejected` - Handyman rejected
-   `completed` - Order completed
-   `cancelled` - Order cancelled

---

## Pagination

Most list endpoints support pagination:

-   Default per_page: 15
-   Query: `?page=2&per_page=20`

---

## Mobile App Example Usage

### Register & Login

```javascript
// Register
const registerResponse = await fetch(
    "http://localhost:8000/api/v1/auth/register",
    {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            fname: "John",
            lname: "Doe",
            email: "john@example.com",
            password: "password123",
            password_confirmation: "password123",
        }),
    }
);

const { access_token } = await registerResponse.json();

// Subsequent requests
const headers = {
    Authorization: `Bearer ${access_token}`,
    "Content-Type": "application/json",
};

// Get current user
const userResponse = await fetch("http://localhost:8000/api/v1/user", {
    headers,
});
const { data: user } = await userResponse.json();
```

---
