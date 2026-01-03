# Admin Interface Architecture & Navigation Map

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Admin Interface System                    │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────────────────────────────────────────────┐  │
│  │           Admin Middleware (AdminMiddleware.php)      │  │
│  │   ↓ Validates: Authentication + Admin Role Required  │  │
│  └──────────────────────────────────────────────────────┘  │
│                            ↓                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │            Routes (routes/web.php)                    │  │
│  │     /admin/* prefix with auth + admin middleware     │  │
│  └──────────────────────────────────────────────────────┘  │
│                            ↓                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │      Admin Controllers (app/Http/Controllers/Admin/)  │  │
│  │  DashboardController | UserController | GigController│  │
│  │  OrderController     | ReviewController              │  │
│  └──────────────────────────────────────────────────────┘  │
│                            ↓                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │     Database (Users, Gigs, Orders, Reviews)          │  │
│  │  + role field (enum: user, admin)                   │  │
│  │  + last_login_at timestamp                           │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

## Navigation Flow

```
Admin Login
    ↓
/admin/dashboard (Main Hub)
    ├─→ /admin/users (User Management)
    │   ├─→ List all users
    │   ├─→ View user details
    │   ├─→ Edit user
    │   ├─→ Delete user
    │   ├─→ Ban/Unban user
    │   └─→ Export to CSV
    │
    ├─→ /admin/gigs (Gig Management)
    │   ├─→ List all gigs
    │   ├─→ View gig details
    │   ├─→ Edit gig + tiers
    │   ├─→ Delete gig
    │   ├─→ Toggle status
    │   └─→ Export to CSV
    │
    ├─→ /admin/orders (Order Management)
    │   ├─→ List all orders
    │   ├─→ View order details
    │   ├─→ Update order status
    │   ├─→ Cancel order
    │   ├─→ Filter by date
    │   └─→ Export to CSV
    │
    ├─→ /admin/reviews (Review Moderation)
    │   ├─→ List all reviews
    │   ├─→ View review details
    │   ├─→ Flag/Unflag review
    │   ├─→ Delete review
    │   └─→ Export to CSV
    │
    ├─→ /admin/activity-log (Activity Tracking)
    │   └─→ View platform activity
    │
    └─→ /admin/settings (Platform Settings)
        └─→ Configure settings
```

## Admin Dashboard Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                         ADMIN DASHBOARD                              │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  ┌──────────┐ │
│  │   USERS      │  │     GIGS     │  │    ORDERS    │  │  RATING  │ │
│  │     500      │  │      45      │  │     120      │  │  4.6/5   │ │
│  └──────────────┘  └──────────────┘  └──────────────┘  └──────────┘ │
│                                                                       │
│  ┌────────────────────────────────┐  ┌─────────────────────────────┐ │
│  │     Recent Users (Last 5)      │  │   Recent Orders (Last 5)    │ │
│  │                                │  │                             │ │
│  │ • John Doe (5 hours ago)      │  │ Order #102 - Plumbing       │ │
│  │ • Jane Smith (2 days ago)     │  │ Order #101 - Electrical     │ │
│  │ • Mike Johnson (1 week ago)   │  │ Order #100 - Carpentry      │ │
│  │ • Sarah Williams (2 weeks)    │  │ Order #99 - Painting        │ │
│  │ • Tom Brown (1 month ago)     │  │ Order #98 - Cleaning        │ │
│  │                                │  │                             │ │
│  └────────────────────────────────┘  └─────────────────────────────┘ │
│                                                                       │
│  ┌─────────────────────────────────────────────────────────────────┐ │
│  │            Recent Reviews (Last 5)                              │ │
│  │                                                                 │ │
│  │ ★★★★★ Excellent service!            - John Doe (2 hours ago) │ │
│  │ ★★★★☆ Very good, minor issue       - Jane Smith (5 days ago) │ │
│  │ ★★★☆☆ Average work quality         - Mike Johnson (1 week)    │ │
│  │ ★★☆☆☆ Poor communication           - Sarah Williams (flagged) │ │
│  │ ★☆☆☆☆ Do not recommend             - Tom Brown (deleted)     │ │
│  │                                                                 │ │
│  └─────────────────────────────────────────────────────────────────┘ │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

## User Management Interface

```
┌─────────────────────────────────────────────────────────────────────┐
│                      USER MANAGEMENT                                  │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│ Filters: [Search by name/email____] [Role: All ▼] [Status: All ▼]  │
│          [Filter] [Export CSV]                                       │
│                                                                       │
├───────────────────────────────────────────────────────────────────────┤
│  ID │ Name           │ Email              │ Phone  │ Role  │ Status  │
├───────────────────────────────────────────────────────────────────────┤
│ 1  │ John Doe       │ john@example.com   │ 555... │ Admin │ Active  │
│ 2  │ Jane Smith     │ jane@example.com   │ 555... │ User  │ Active  │
│ 3  │ Mike Johnson   │ mike@example.com   │ 555... │ User  │ Inactive│
│ 4  │ Sarah Williams │ sarah@example.com  │ 555... │ User  │ Active  │
│ 5  │ Tom Brown      │ tom@example.com    │ 555... │ User  │ Banned  │
│                                                                       │
│ [View] [Edit] [Delete]  [View] [Edit] [Delete] ...                  │
│                                                                       │
│ ← Previous Page [1][2][3] Next Page →                               │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

## Gig Management Interface

```
┌─────────────────────────────────────────────────────────────────────┐
│                       GIG MANAGEMENT                                  │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│ Search: [Search gigs________] Type: [All ▼] Status: [All ▼]        │
│ [Filter] [Export CSV]                                                │
│                                                                       │
├───────────────────────────────────────────────────────────────────────┤
│ Title          │ Type      │ Handyman      │ Tiers │ Status │ Date   │
├───────────────────────────────────────────────────────────────────────┤
│ Pipe Cleaning  │ Plumbing  │ John Doe      │ 3T   │ Active │ Jan 1  │
│ Light Install  │ Electric  │ Jane Smith    │ 3T   │ Active │ Jan 2  │
│ Wood Repair    │ Carpentry │ Mike Johnson  │ 3T   │ Inactive│ Jan 3 │
│ House Painting │ Painting  │ Sarah W.      │ 3T   │ Active │ Jan 4  │
│ Deep Cleaning  │ Cleaning  │ Tom Brown     │ 3T   │ Active │ Jan 5  │
│                                                                       │
│ [View] [Edit] [Delete]  [View] [Edit] [Delete] ...                  │
│                                                                       │
│ ← Previous Page [1][2][3] Next Page →                               │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

## Order Management Interface

```
┌─────────────────────────────────────────────────────────────────────┐
│                      ORDER MANAGEMENT                                 │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│ Search: [Order ID/Email____] Status: [All ▼] From: [__/__/__]      │
│ To: [__/__/__] [Filter] [Export CSV]                                │
│                                                                       │
├───────────────────────────────────────────────────────────────────────┤
│  ID  │ Client              │ Gig            │ Status      │ Price  │
├───────────────────────────────────────────────────────────────────────┤
│ #102 │ john@example.com    │ Pipe Cleaning  │ Completed   │ $75    │
│ #101 │ jane@example.com    │ Light Install  │ In Progress │ $150   │
│ #100 │ mike@example.com    │ Wood Repair    │ Accepted    │ $200   │
│ #99  │ sarah@example.com   │ House Painting │ Pending     │ $500   │
│ #98  │ tom@example.com     │ Deep Cleaning  │ Completed   │ $100   │
│                                                                       │
│ [View] [Cancel]  [View] [Cancel] ...                                │
│                                                                       │
│ ← Previous Page [1][2][3] Next Page →                               │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

## Review Management Interface

```
┌─────────────────────────────────────────────────────────────────────┐
│                     REVIEW MANAGEMENT                                 │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│ Search: [Search reviews_____] Rating: [All ▼] Status: [All ▼]      │
│ [Filter] [Export CSV]                                                │
│                                                                       │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│ ┌──────────────────────────────────────────────────────────────┐   │
│ │ John Doe  ★★★★★  Excellent service!                         │   │
│ │ For: Pipe Cleaning                                           │   │
│ │ The handyman was professional and completed the job quickly.│   │
│ │ Would definitely hire again!                                 │   │
│ │                                                              │   │
│ │ [Flag] [Delete]                           2 hours ago       │   │
│ └──────────────────────────────────────────────────────────────┘   │
│                                                                       │
│ ┌──────────────────────────────────────────────────────────────┐   │
│ │ Jane Smith  ★★★★☆  Good work overall                        │   │
│ │ For: Light Installation                                      │   │
│ │ The job was done well but took longer than expected.        │   │
│ │ Would still recommend.                                       │   │
│ │                                                              │   │
│ │ [Flag] [Delete]                           5 days ago        │   │
│ └──────────────────────────────────────────────────────────────┘   │
│                                                                       │
│ [Flag] [Delete]  [Flag] [Delete] ...                                │
│                                                                       │
│ ← Previous Page [1][2][3] Next Page →                               │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

## Admin Routes Structure

```
/admin/
├── dashboard                              # GET  Dashboard overview
├── activity-log                           # GET  Activity tracking
├── settings                               # GET  Platform settings
│
├── users
│   ├── (index)                           # GET  List users
│   ├── {id}                              # GET  View user
│   ├── {id}/edit                         # GET  Edit form
│   ├── {id}                              # PUT  Update user
│   ├── {id}                              # DELETE Delete user
│   ├── {id}/toggle-ban                   # POST Ban/unban
│   └── export/csv                        # GET  Export users
│
├── gigs
│   ├── (index)                           # GET  List gigs
│   ├── {id}                              # GET  View gig
│   ├── {id}/edit                         # GET  Edit form
│   ├── {id}                              # PUT  Update gig
│   ├── {id}                              # DELETE Delete gig
│   ├── {id}/toggle-status                # POST Toggle status
│   └── export/csv                        # GET  Export gigs
│
├── orders
│   ├── (index)                           # GET  List orders
│   ├── {id}                              # GET  View order
│   ├── {id}/update-status                # POST Update status
│   ├── {id}/cancel                       # POST Cancel order
│   └── export/csv                        # GET  Export orders
│
└── reviews
    ├── (index)                           # GET  List reviews
    ├── {id}                              # GET  View review
    ├── {id}/toggle-flag                  # POST Flag/unflag
    ├── {id}                              # DELETE Delete review
    └── export/csv                        # GET  Export reviews
```

## Data Flow Diagram

```
                          ┌─────────────┐
                          │ Admin Login  │
                          └──────┬──────┘
                                 │
                    ┌────────────┴────────────┐
                    │                         │
                    ↓                         ↓
            ┌──────────────┐        ┌──────────────────┐
            │   Validate   │        │  Check DB Role   │
            │   Auth       │        │  = 'admin'       │
            └──────┬───────┘        └────────┬─────────┘
                   │                         │
                   └────────────┬────────────┘
                                │
                                ↓
                    ┌──────────────────────┐
                    │  Load Admin Routes   │
                    └──────────┬───────────┘
                               │
                ┌──────────────┼──────────────┐
                │              │              │
                ↓              ↓              ↓
          ┌─────────┐   ┌───────────┐  ┌──────────┐
          │ Users   │   │   Gigs    │  │ Orders   │
          │ List/   │   │ List/Edit │  │ Monitor  │
          │ Edit    │   │ Tiers     │  │ Status   │
          └────┬────┘   └─────┬─────┘  └────┬─────┘
               │              │             │
               ↓              ↓             ↓
          ┌─────────┐   ┌───────────┐  ┌──────────┐
          │Database │   │Database   │  │Database  │
          │ users   │   │ gigs      │  │ orders   │
          │ table   │   │ table     │  │ table    │
          └─────────┘   └───────────┘  └──────────┘
```

## Role-Based Access Control

```
┌────────────────────────────────────────────────────┐
│                User Roles                          │
├────────────────────────────────────────────────────┤
│                                                    │
│  REGULAR USER (role = 'user')                     │
│  ├─ Browse gigs ✓                                 │
│  ├─ Create orders ✓                               │
│  ├─ Create gigs (if handyman) ✓                   │
│  ├─ Access /admin/dashboard ✗                     │
│  └─ Manage platform ✗                             │
│                                                    │
│  ADMIN USER (role = 'admin')                      │
│  ├─ Browse gigs ✓                                 │
│  ├─ Create orders ✓                               │
│  ├─ Create gigs ✓                                 │
│  ├─ Access /admin/dashboard ✓                     │
│  ├─ Manage users ✓                                │
│  ├─ Manage gigs ✓                                 │
│  ├─ Monitor orders ✓                              │
│  ├─ Moderate reviews ✓                            │
│  └─ Export data ✓                                 │
│                                                    │
└────────────────────────────────────────────────────┘
```

---

This admin interface provides complete platform management capabilities with a clean, intuitive interface.
