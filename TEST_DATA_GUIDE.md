# 🎉 Test Data Successfully Created!

Your MOQAF database has been populated with comprehensive fake data for testing.

## 📊 What Was Created

### 👥 Users

-   **10 Clients** with complete profiles

    -   Example: `sarah0@example.com` / `password123`
    -   All have client profiles created
    -   Located in different cities

-   **15 Handymen** with professional profiles
    -   Example: `ahmed0@handyman.com` / `password123`
    -   Each has unique services and bio
    -   Specializing in different trades

### 🏷️ Categories

-   **6 Parent Categories** with icons

    -   Home Repair 🏠
    -   Cleaning Services 🧹
    -   Installation 🔨
    -   Maintenance 🔧
    -   Outdoor Services 🌳
    -   Moving & Delivery 📦

-   **21 Subcategories** for detailed organization
    -   Plumbing, Electrical, Carpentry, Painting, etc.

### 💼 Gigs

-   **25+ Service Gigs** created
    -   Each linked to appropriate categories
    -   Attached to handymen
    -   Includes realistic descriptions
    -   Fake images from placeholder service
    -   Created over the past 90 days

### 📦 Orders

-   **30-50 Orders** with varied statuses
    -   50% completed ✅
    -   20% accepted 🤝
    -   15% pending ⏳
    -   10% rejected ❌
    -   5% cancelled 🚫

### ⭐ Reviews & Ratings

-   **~70% of completed orders** have reviews
    -   Weighted towards positive ratings (50% are 5-star)
    -   Realistic comments for each rating level
    -   60% of 4-5 star reviews have handyman responses
    -   Notifications generated for reviews and responses

### ❤️ Favorites

-   Each client has 2-5 favorite items
-   Mix of favorite gigs and handymen
-   Some users have more, some less

### 🔔 Notifications

-   5-10 notifications per user
-   Mix of read and unread (40% read)
-   Various notification types:
    -   New orders
    -   Order status changes
    -   New messages
    -   Reviews and responses
    -   Gig applications

---

## 🧪 Test Accounts

### Client Account

```
Email: sarah0@example.com
Password: password123
Role: Client
Has: Orders, Reviews, Favorites, Notifications
```

### Handyman Account

```
Email: ahmed0@handyman.com
Password: password123
Role: Handyman
Services: Plumbing, Electrical
Has: Gigs, Orders, Reviews, Notifications
```

### More Test Accounts

-   Clients: `mohammed1@example.com`, `fatima2@example.com`, etc.
-   Handymen: `faisal1@handyman.com`, `yasser2@handyman.com`, etc.
-   All use password: `password123`

---

## 🔍 Test Queries to Try

### Get All Gigs with Reviews

```bash
curl http://localhost:8000/api/v1/gigs
```

### Get Handyman with Reviews

```bash
curl http://localhost:8000/api/v1/handymen/15/reviews
```

### Login as Client

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "sarah0@example.com",
    "password": "password123"
  }'
```

### Get Favorites (after login)

```bash
curl http://localhost:8000/api/v1/favorites \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Get Notifications

```bash
curl http://localhost:8000/api/v1/notifications \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Get Categories

```bash
curl http://localhost:8000/api/v1/categories
```

### Get Popular Categories

```bash
curl http://localhost:8000/api/v1/categories/popular
```

---

## 📈 Database Statistics

Run these queries in your database to verify:

```sql
-- Count users
SELECT
  (SELECT COUNT(*) FROM users) as total_users,
  (SELECT COUNT(*) FROM client) as total_clients,
  (SELECT COUNT(*) FROM handyman) as total_handymen;

-- Count gigs and categories
SELECT
  (SELECT COUNT(*) FROM gigs) as total_gigs,
  (SELECT COUNT(*) FROM categories) as total_categories;

-- Count orders by status
SELECT status, COUNT(*) as count
FROM orders
GROUP BY status
ORDER BY count DESC;

-- Count reviews with ratings
SELECT rating, COUNT(*) as count
FROM reviews
GROUP BY rating
ORDER BY rating DESC;

-- Average rating per handyman
SELECT h.handyman_id, u.fname, u.lname,
       ROUND(AVG(r.rating), 2) as avg_rating,
       COUNT(r.review_id) as total_reviews
FROM handyman h
JOIN users u ON h.handyman_id = u.id
LEFT JOIN reviews r ON r.handyman_id = h.handyman_id
GROUP BY h.handyman_id, u.fname, u.lname
HAVING COUNT(r.review_id) > 0
ORDER BY avg_rating DESC;

-- Count favorites
SELECT favoritable_type, COUNT(*) as count
FROM favorites
GROUP BY favoritable_type;

-- Count notifications
SELECT
  COUNT(*) as total_notifications,
  COUNT(CASE WHEN read_at IS NULL THEN 1 END) as unread_count,
  COUNT(CASE WHEN read_at IS NOT NULL THEN 1 END) as read_count
FROM notifications;
```

---

## 🎯 Testing Scenarios

### Scenario 1: Browse Gigs by Category

1. Get all categories
2. Select "Plumbing" category
3. View plumbing gigs
4. Add gig to favorites

### Scenario 2: Handyman Profile

1. Login as handyman
2. View your gigs
3. Check received reviews
4. Respond to a review

### Scenario 3: Client Journey

1. Login as client
2. Browse gigs
3. View a handyman's profile and reviews
4. Check order history
5. Submit a review for completed order

### Scenario 4: Notifications

1. Login as any user
2. Check notification count
3. View all notifications
4. Mark some as read
5. Delete read notifications

---

## 🚀 Next Steps

1. **Test the API endpoints** using the Quick Start guide
2. **Integrate with frontend** using the examples provided
3. **Create admin panel** to manage this data
4. **Add more test data** if needed:
    ```bash
    php artisan db:seed --class=GigSeeder
    php artisan db:seed --class=OrderSeeder
    ```
5. **Clear test data when ready for production**:
    ```bash
    php artisan migrate:fresh
    ```

---

## ⚠️ Important Notes

-   All passwords are `password123` (change in production!)
-   Review ratings are weighted towards positive (realistic simulation)
-   Some data is randomized, so exact counts may vary
-   Photos use placeholder images from picsum.photos
-   Notifications include read/unread status simulation
-   Orders span the last 90 days for realistic testing

---

## 🔄 Reset Test Data

If you want to reset and recreate all test data:

```bash
# Clear everything and recreate
php artisan migrate:fresh

# Run all seeders (categories were already seeded)
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=GigSeeder
php artisan db:seed --class=OrderSeeder
php artisan db:seed --class=ReviewSeeder
php artisan db:seed --class=FavoriteSeeder
php artisan db:seed --class=NotificationSeeder
```

---

Happy Testing! 🎊
