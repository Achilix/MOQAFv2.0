# 🚀 Quick Start Guide - New Features

## Testing New Endpoints

### 1. Categories (Public - No Auth Required)

```bash
# Get all categories
curl http://localhost:8000/api/v1/categories

# Get popular categories
curl http://localhost:8000/api/v1/categories/popular

# Get specific category with gigs
curl http://localhost:8000/api/v1/categories/1
```

**Expected Response:**

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

---

### 2. Reviews & Ratings

#### Step 1: Complete an order first

The order must have status "completed" before you can review it.

#### Step 2: Create a review (Protected)

```bash
curl -X POST http://localhost:8000/api/v1/reviews \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": 1,
    "rating": 5,
    "comment": "Excellent work! Very professional and on time."
  }'
```

#### Step 3: View handyman reviews (Public)

```bash
curl http://localhost:8000/api/v1/handymen/1/reviews
```

**Expected Response:**

```json
{
    "reviews": {
        "data": [
            {
                "id": 1,
                "rating": 5,
                "comment": "Excellent work!",
                "client": {
                    "fname": "John",
                    "lname": "Doe"
                },
                "created_at": "2026-01-02T10:00:00Z"
            }
        ]
    },
    "statistics": {
        "average_rating": 5.0,
        "total_reviews": 1
    }
}
```

#### Handyman Response to Review

```bash
curl -X POST http://localhost:8000/api/v1/reviews/1/respond \
  -H "Authorization: Bearer HANDYMAN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "response": "Thank you for your kind words!"
  }'
```

---

### 3. Favorites/Bookmarks

#### Add a gig to favorites

```bash
curl -X POST http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "gig",
    "id": 1
  }'
```

#### Add a handyman to favorites

```bash
curl -X POST http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "handyman",
    "id": 1
  }'
```

#### Get all favorites

```bash
curl http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer YOUR_TOKEN"

# Filter by type
curl "http://localhost:8000/api/v1/favorites?type=gig" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Check if item is favorited

```bash
curl "http://localhost:8000/api/v1/favorites/check?type=gig&id=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected Response:**

```json
{
    "is_favorited": true
}
```

#### Remove from favorites

```bash
curl -X DELETE http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "gig",
    "id": 1
  }'
```

---

### 4. Notifications

#### Get all notifications

```bash
curl http://localhost:8000/api/v1/notifications \
  -H "Authorization: Bearer YOUR_TOKEN"

# Get only unread
curl "http://localhost:8000/api/v1/notifications?unread_only=true" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Get unread count

```bash
curl http://localhost:8000/api/v1/notifications/unread-count \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected Response:**

```json
{
    "unread_count": 3
}
```

#### Mark notification as read

```bash
curl -X POST http://localhost:8000/api/v1/notifications/1/read \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Mark all as read

```bash
curl -X POST http://localhost:8000/api/v1/notifications/read-all \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Delete notification

```bash
curl -X DELETE http://localhost:8000/api/v1/notifications/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔧 Integration Examples

### React/React Native - Favorites Feature

```javascript
// favoriteService.js
export const favoriteService = {
    async addToFavorites(type, id, token) {
        const response = await fetch("http://localhost:8000/api/v1/favorites", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ type, id }),
        });
        return response.json();
    },

    async checkFavorite(type, id, token) {
        const response = await fetch(
            `http://localhost:8000/api/v1/favorites/check?type=${type}&id=${id}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        return response.json();
    },

    async getFavorites(token, type = null) {
        const url = type
            ? `http://localhost:8000/api/v1/favorites?type=${type}`
            : "http://localhost:8000/api/v1/favorites";

        const response = await fetch(url, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        return response.json();
    },
};

// Usage in component
const handleFavorite = async (gigId) => {
    try {
        await favoriteService.addToFavorites("gig", gigId, userToken);
        showSuccess("Added to favorites!");
    } catch (error) {
        showError("Failed to add to favorites");
    }
};
```

### React - Categories Filter

```javascript
// CategoriesFilter.jsx
import { useState, useEffect } from "react";

export const CategoriesFilter = ({ onSelectCategory }) => {
    const [categories, setCategories] = useState([]);

    useEffect(() => {
        fetch("http://localhost:8000/api/v1/categories")
            .then((res) => res.json())
            .then((data) => setCategories(data.categories));
    }, []);

    return (
        <div className="categories-filter">
            {categories.map((category) => (
                <div key={category.id} className="category-card">
                    <span className="icon">{category.icon}</span>
                    <h3>{category.name}</h3>
                    <button onClick={() => onSelectCategory(category.id)}>
                        View {category.gigs_count || 0} Gigs
                    </button>

                    {category.children?.length > 0 && (
                        <div className="subcategories">
                            {category.children.map((child) => (
                                <button
                                    key={child.id}
                                    onClick={() => onSelectCategory(child.id)}
                                >
                                    {child.icon} {child.name}
                                </button>
                            ))}
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};
```

### React - Reviews Component

```javascript
// ReviewForm.jsx
import { useState } from "react";

export const ReviewForm = ({ orderId, token, onSuccess }) => {
    const [rating, setRating] = useState(5);
    const [comment, setComment] = useState("");

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const response = await fetch(
                "http://localhost:8000/api/v1/reviews",
                {
                    method: "POST",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        rating,
                        comment,
                    }),
                }
            );

            if (response.ok) {
                onSuccess();
            }
        } catch (error) {
            console.error("Failed to submit review:", error);
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="rating-input">
                {[1, 2, 3, 4, 5].map((star) => (
                    <button
                        key={star}
                        type="button"
                        onClick={() => setRating(star)}
                        className={star <= rating ? "active" : ""}
                    >
                        ⭐
                    </button>
                ))}
            </div>

            <textarea
                value={comment}
                onChange={(e) => setComment(e.target.value)}
                placeholder="Share your experience..."
                maxLength={1000}
            />

            <button type="submit">Submit Review</button>
        </form>
    );
};
```

### React - Notifications Bell

```javascript
// NotificationBell.jsx
import { useState, useEffect } from "react";

export const NotificationBell = ({ token }) => {
    const [unreadCount, setUnreadCount] = useState(0);
    const [notifications, setNotifications] = useState([]);
    const [showDropdown, setShowDropdown] = useState(false);

    useEffect(() => {
        fetchUnreadCount();
        // Poll every 30 seconds
        const interval = setInterval(fetchUnreadCount, 30000);
        return () => clearInterval(interval);
    }, [token]);

    const fetchUnreadCount = async () => {
        const response = await fetch(
            "http://localhost:8000/api/v1/notifications/unread-count",
            {
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        const data = await response.json();
        setUnreadCount(data.unread_count);
    };

    const fetchNotifications = async () => {
        const response = await fetch(
            "http://localhost:8000/api/v1/notifications",
            {
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        const data = await response.json();
        setNotifications(data.notifications.data);
    };

    const markAsRead = async (notificationId) => {
        await fetch(
            `http://localhost:8000/api/v1/notifications/${notificationId}/read`,
            {
                method: "POST",
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        fetchUnreadCount();
        fetchNotifications();
    };

    const handleClick = () => {
        setShowDropdown(!showDropdown);
        if (!showDropdown) {
            fetchNotifications();
        }
    };

    return (
        <div className="notification-bell">
            <button onClick={handleClick}>
                🔔
                {unreadCount > 0 && (
                    <span className="badge">{unreadCount}</span>
                )}
            </button>

            {showDropdown && (
                <div className="notifications-dropdown">
                    {notifications.map((notif) => (
                        <div
                            key={notif.id}
                            className={`notification-item ${
                                notif.is_read ? "read" : "unread"
                            }`}
                            onClick={() => markAsRead(notif.id)}
                        >
                            <h4>{notif.title}</h4>
                            <p>{notif.message}</p>
                            <small>
                                {new Date(notif.created_at).toLocaleString()}
                            </small>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};
```

---

## 📱 Mobile App Implementation Tips

### 1. Push Notifications Setup

When a notification is created in the database, also send a push notification:

```php
// In your notification creation logic
use Illuminate\Support\Facades\Http;

public function sendPushNotification($userId, $title, $message, $data)
{
    $user = User::find($userId);

    if ($user->fcm_token) {
        Http::post('https://fcm.googleapis.com/fcm/send', [
            'to' => $user->fcm_token,
            'notification' => [
                'title' => $title,
                'body' => $message,
            ],
            'data' => $data,
        ])->withHeaders([
            'Authorization' => 'key=' . env('FCM_SERVER_KEY'),
        ]);
    }
}
```

### 2. Offline Favorites

Cache favorites locally:

```javascript
// AsyncStorage for React Native
import AsyncStorage from "@react-native-async-storage/async-storage";

export const offlineFavorites = {
    async syncFavorites(token) {
        const response = await fetch("http://localhost:8000/api/v1/favorites", {
            headers: { Authorization: `Bearer ${token}` },
        });
        const data = await response.json();
        await AsyncStorage.setItem(
            "favorites",
            JSON.stringify(data.favorites.data)
        );
    },

    async getCachedFavorites() {
        const cached = await AsyncStorage.getItem("favorites");
        return cached ? JSON.parse(cached) : [];
    },
};
```

---

## 🎯 Common Use Cases

### Use Case 1: Client Reviews Handyman After Job

```javascript
// 1. Order is completed (status: 'completed')
// 2. Show review prompt to client
// 3. Client submits review
// 4. Handyman gets notification
// 5. Handyman can view and respond to review
```

### Use Case 2: User Browses Gigs by Category

```javascript
// 1. User sees category list on homepage
// 2. Clicks "Home Repair" → sees subcategories
// 3. Clicks "Plumbing" → sees filtered gigs
// 4. Can favorite gigs for later
// 5. Gets notifications when favorited handymen post new gigs
```

### Use Case 3: Handyman Gets New Order

```javascript
// 1. Client creates order
// 2. Notification created in database
// 3. Push notification sent to handyman
// 4. Handyman opens app → sees notification bell with count
// 5. Clicks notification → navigates to order details
// 6. Accepts or rejects order
```

---

## 🔐 Security Notes

1. **Rate Limiting Active**: Don't exceed limits or requests will be throttled
2. **Authorization**: Most endpoints require valid Bearer token
3. **Input Validation**: All inputs are validated - check error messages
4. **24-Hour Window**: Reviews can only be edited/deleted within 24 hours
5. **Order Verification**: Can only review orders you're part of and are completed

---

## 🐛 Troubleshooting

### "Unauthenticated" Error

-   Ensure Bearer token is included in Authorization header
-   Token format: `Authorization: Bearer YOUR_TOKEN`

### "Review already exists" Error

-   Each order can only be reviewed once
-   Check if you've already reviewed this order

### "Order must be completed" Error

-   Order status must be 'completed' before reviewing
-   Have the handyman complete the order first

### "Category not found" Error

-   Run the seeder: `php artisan db:seed --class=CategorySeeder`
-   Or create categories manually via API

### Rate Limit Exceeded

-   Wait for the rate limit to reset (shown in Retry-After header)
-   Reduce request frequency

---

## ✅ Checklist

-   [x] Migrations run successfully
-   [x] Categories seeded
-   [x] API endpoints documented
-   [x] Rate limiting configured
-   [x] Validation rules in place
-   [x] Soft deletes enabled
-   [ ] Test all endpoints with Postman
-   [ ] Integrate with frontend
-   [ ] Set up push notifications
-   [ ] Configure production environment

---

Happy coding! 🎉
