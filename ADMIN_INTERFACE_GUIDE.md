# Admin Interface Documentation

## Overview

The MOQAF admin interface provides comprehensive management tools for all aspects of the platform. Admins can manage users, gigs, orders, and reviews with full control over the platform.

## Access & Authentication

### Admin Login

1. Navigate to `/login`
2. Log in with admin account credentials
3. Admin users with `role = 'admin'` automatically see the admin option

### Admin Dashboard

-   **URL**: `/admin/dashboard`
-   **Accessible**: Only to users with `role = 'admin'`
-   **Middleware**: `AdminMiddleware` protects all admin routes

## Features

### 1. Dashboard Overview

**Main Statistics:**

-   Total Users (Clients + Handymen)
-   Total Gigs
-   Total Orders (Pending + Completed)
-   Average Platform Rating
-   Recent Users (Last 5)
-   Recent Orders (Last 5)
-   Recent Reviews (Last 5)

**Quick Navigation:**

-   Links to all management sections
-   Export functionality for data
-   Activity log and settings

---

### 2. User Management

**URL**: `/admin/users`

#### List Users

-   View all platform users
-   Filter by:
    -   Name/Email search
    -   Role (User/Admin)
    -   Status (Active/Inactive)
-   Pagination (20 per page)
-   Export to CSV

#### User Actions

**View Details** (`/admin/users/{id}`)

-   Full user profile
-   Contact information
-   Associated client/handyman profile
-   Account creation date
-   Last login timestamp

**Edit User** (`/admin/users/{id}/edit`)

-   Update name, email, phone
-   Change user role to admin
-   Modify address and government ID

**Delete User** (`/admin/users/{id}`)

-   Permanently remove user account
-   Cascades related data

**Ban/Unban User**

-   Temporarily disable user account
-   User cannot log in when banned
-   Existing orders preserved

#### CSV Export

-   Downloads all user data
-   Includes: ID, Name, Email, Phone, Role, Created Date
-   Filename: `users_YYYY-MM-DD_HH-MM-SS.csv`

---

### 3. Gig Management

**URL**: `/admin/gigs`

#### List Gigs

-   View all service gigs
-   Filter by:
    -   Title/Description search
    -   Service type (Plumbing, Electrical, etc.)
    -   Status (Active/Inactive)
-   Shows tier count for each gig
-   Pagination (20 per page)
-   Export to CSV

#### Gig Actions

**View Details** (`/admin/gigs/{id}`)

-   Complete gig information
-   Associated handyman(s)
-   All pricing tiers (BASIC/MEDIUM/PREMIUM)
-   Tier details: price, description, delivery days
-   Creation and update timestamps

**Edit Gig** (`/admin/gigs/{id}/edit`)

-   Update title, type, description
-   Modify pricing tiers:
    -   Edit tier descriptions
    -   Update prices
    -   Change delivery timeframes
-   Toggle active/inactive status
-   Update photos

**Delete Gig** (`/admin/gigs/{id}`)

-   Permanently delete gig
-   Removes all associated tiers
-   Cancels related pending orders

**Toggle Status**

-   Quickly activate/deactivate gig
-   Inactive gigs don't appear in search
-   Existing orders unaffected

#### CSV Export

-   Downloads gig data
-   Includes: ID, Title, Type, Handyman, Tier Count, Status, Created Date

---

### 4. Order Management

**URL**: `/admin/orders`

#### List Orders

-   View all platform orders
-   Filter by:
    -   Order ID/Client email search
    -   Status (Pending/Accepted/In Progress/Completed/Cancelled)
    -   Date range (From/To)
-   Shows client email, gig title, order value
-   Pagination (20 per page)
-   Export to CSV

#### Order Statuses

-   **Pending**: Newly created, awaiting handyman response
-   **Accepted**: Handyman accepted the order
-   **In Progress**: Work in progress
-   **Completed**: Order finished
-   **Cancelled**: Order was cancelled

#### Order Actions

**View Details** (`/admin/orders/{id}`)

-   Client information
-   Gig details
-   Selected tier information
-   Order price and timeline
-   Order creation and completion dates
-   Current status

**Update Status** (`/admin/orders/{id}/update-status`)

-   Manually change order status
-   Useful for fixing incorrect statuses
-   Notifies both parties

**Cancel Order** (`/admin/orders/{id}/cancel`)

-   Cancel active orders
-   Refund processing (if applicable)
-   Notification sent to both parties

#### CSV Export

-   Downloads order data
-   Includes: ID, Client Email, Gig, Status, Price, Date
-   Includes date filters applied

---

### 5. Review Management

**URL**: `/admin/reviews`

#### List Reviews

-   View all platform reviews
-   Filter by:
    -   Review content search
    -   Star rating (1-5 stars)
    -   Status (Approved/Flagged)
-   Shows reviewer, rating, gig, status
-   Pagination (20 per page)
-   Export to CSV

#### Review Actions

**View Details**

-   Reviewer information
-   Complete review text
-   Associated gig
-   Star rating
-   Flag status
-   Review date

**Flag Review**

-   Mark review as inappropriate
-   Hidden from public display
-   Flagged reviews highlighted in admin list

**Unflag Review**

-   Remove inappropriate flag
-   Review becomes visible again

**Delete Review**

-   Permanently remove review
-   Affects gig rating average
-   Action is logged

#### CSV Export

-   Downloads review data
-   Includes: ID, Reviewer, Gig, Rating, Comment snippet, Status, Date

---

## Admin Operations

### Creating an Admin User

**Via Database:**

```sql
UPDATE users SET role = 'admin' WHERE id = 1;
```

**Via Admin Interface:**

1. Go to User Management
2. Edit desired user
3. Change role to "Admin"
4. Save

### Bulk Export Data

**Users:** `/admin/users/export`

-   All users with filters applied

**Gigs:** `/admin/gigs/export`

-   All gigs with tier information

**Orders:** `/admin/orders/export`

-   Orders with date filters applied

**Reviews:** `/admin/reviews/export`

-   Reviews with status filters applied

### Platform Monitoring

**Dashboard Statistics:**

-   Real-time user count
-   Active orders count
-   Average rating overview
-   Recent activity feed

**Activity Log:**

-   Tracks admin actions
-   User registrations
-   Order updates
-   Review moderation

---

## Security Features

### Role-Based Access Control

-   Only admin users can access `/admin/*` routes
-   `AdminMiddleware` validates every admin request
-   Non-admins receive 403 Forbidden error

### Data Protection

-   CSV exports contain anonymized/minimal data
-   Sensitive fields excluded (passwords, payment info)
-   All admin actions logged

### User Account Management

-   Ban/unban functionality
-   Role management
-   Account deletion with cascade

---

## Database Models for Admin

### User Model

```php
- id: int (primary key)
- fname, lname: string
- email: string (unique)
- phone_number: nullable string
- role: enum('user', 'admin')
- email_verified_at: nullable timestamp
- last_login_at: nullable timestamp
- created_at, updated_at: timestamp
```

### Gig Model

```php
- id_gig: int (primary key)
- title: string
- type: string
- description: text
- is_active: boolean
- created_at, updated_at: timestamp
- soft deletes: deleted_at
```

### Order Model

```php
- id: int (primary key)
- client_id: foreign key
- gig_id: foreign key
- status: enum (pending/accepted/in_progress/completed/cancelled)
- total_price: decimal
- created_at, updated_at: timestamp
```

### Review Model

```php
- id: int (primary key)
- user_id: foreign key
- gig_id: foreign key
- rating: integer (1-5)
- comment: text
- is_flagged: boolean
- created_at, updated_at: timestamp
```

### GigTier Model

```php
- id: int (primary key)
- id_gig: foreign key
- tier_name: enum (BASIC/MEDIUM/PREMIUM)
- description: text
- base_price: decimal
- delivery_days: integer
- created_at, updated_at: timestamp
- soft deletes: deleted_at
```

---

## Common Admin Tasks

### Deactivate Suspicious Gig

1. Go to `/admin/gigs`
2. Search for gig
3. Click "Toggle Status"
4. Gig becomes inactive

### Delete Abusive User

1. Go to `/admin/users`
2. Search for user
3. Click "Delete"
4. Confirm deletion

### Moderate Negative Review

1. Go to `/admin/reviews`
2. Find review
3. Click "Flag" to hide
4. Or "Delete" to remove permanently

### Monitor Order Progress

1. Go to `/admin/orders`
2. Filter by status "In Progress"
3. Click order to see details
4. Update status if needed

### Generate Monthly Report

1. Go to each management section (Users, Gigs, Orders, Reviews)
2. Set appropriate date filters
3. Click "Export CSV"
4. Download and analyze data

---

## Troubleshooting

### Can't Access Admin Panel

-   Verify user role is 'admin'
-   Check database: `SELECT role FROM users WHERE id = ?`
-   Clear browser cache and try again

### Missing Data in Export

-   Verify filters are not too restrictive
-   Check if records exist in database
-   Export includes only filtered results

### User Can't Login

-   Check if user account is banned
-   Verify email_verified_at is not null
-   Check password reset needed

---

## Best Practices

### Security

1. Only grant admin role to trusted users
2. Regularly review admin action logs
3. Archive old reports for compliance
4. Don't share admin credentials

### Operations

1. Regularly export data for backups
2. Monitor flagged reviews
3. Keep user database clean
4. Archive completed orders

### Data Management

1. Regular backups before deletions
2. Use CSV exports for reporting
3. Document major admin actions
4. Test changes on test data first

---

## Support & Documentation

For additional help:

-   Check Dashboard for quick stats
-   Review API documentation
-   Contact development team
-   Check activity logs for issues
