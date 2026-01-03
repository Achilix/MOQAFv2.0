# Admin Interface Setup & Quick Start

## Getting Started with Admin Features

The MOQAF platform now includes a complete admin interface for managing all aspects of the platform.

## Setup

### 1. Create Your First Admin User

**Option A: Via Database**
```sql
UPDATE users SET role = 'admin' WHERE id = 1;
```

**Option B: Via Laravel Tinker**
```bash
php artisan tinker
```

```php
$user = User::find(1);
$user->role = 'admin';
$user->save();
```

### 2. Access Admin Dashboard

Once you have admin access:
1. Log in with your admin credentials at `/login`
2. Navigate to `/admin/dashboard`
3. You'll see the admin dashboard with all management options

## Admin Features Available

### Dashboard (`/admin/dashboard`)
- **At a Glance Statistics:**
  - Total users, clients, handymen
  - Total gigs and orders
  - Order status breakdown (pending, completed)
  - Average platform rating
  - Recent users, orders, and reviews

### User Management (`/admin/users`)
- **View all users** with search and filtering
- **Edit users** - update profile information
- **Change roles** - promote users to admin
- **Delete users** - remove user accounts
- **Ban/Unban users** - disable accounts temporarily
- **Export data** - download user list as CSV

### Gig Management (`/admin/gigs`)
- **List all gigs** with service type filtering
- **View gig details** including all pricing tiers
- **Edit gigs** - update information and pricing tiers
- **Toggle status** - activate/deactivate services
- **Delete gigs** - remove services from platform
- **Export data** - download gig list as CSV

### Order Management (`/admin/orders`)
- **Monitor all orders** with status filtering
- **View order details** - client, gig, pricing, timeline
- **Update order status** - manually change status if needed
- **Cancel orders** - stop orders and process refunds
- **Filter by date** - track orders over time
- **Export data** - download order list as CSV

### Review Management (`/admin/reviews`)
- **Monitor all reviews** with rating filtering
- **View full reviews** with context
- **Flag reviews** - mark inappropriate content
- **Delete reviews** - remove from platform
- **Filter by status** - approved vs flagged
- **Export data** - download review list as CSV

### Activity Log & Settings
- **Activity tracking** - see admin actions and platform events
- **Settings page** - configure platform settings

## Key Routes

```
GET    /admin/dashboard              - Main dashboard
GET    /admin/users                  - User list
GET    /admin/users/{id}             - User details
GET    /admin/users/{id}/edit        - Edit user
PUT    /admin/users/{id}             - Update user
POST   /admin/users/{id}/toggle-ban  - Ban/unban user
DELETE /admin/users/{id}             - Delete user
GET    /admin/users/export/csv       - Export users

GET    /admin/gigs                   - Gig list
GET    /admin/gigs/{id}              - Gig details
GET    /admin/gigs/{id}/edit         - Edit gig
PUT    /admin/gigs/{id}              - Update gig
POST   /admin/gigs/{id}/toggle-status - Toggle gig status
DELETE /admin/gigs/{id}              - Delete gig
GET    /admin/gigs/export/csv        - Export gigs

GET    /admin/orders                 - Order list
GET    /admin/orders/{id}            - Order details
POST   /admin/orders/{id}/update-status - Update status
POST   /admin/orders/{id}/cancel     - Cancel order
GET    /admin/orders/export/csv      - Export orders

GET    /admin/reviews                - Review list
GET    /admin/reviews/{id}           - Review details
POST   /admin/reviews/{id}/toggle-flag - Flag/unflag review
DELETE /admin/reviews/{id}           - Delete review
GET    /admin/reviews/export/csv     - Export reviews
```

## Common Tasks

### Make a User an Admin
1. Go to `/admin/users`
2. Search for the user
3. Click "Edit"
4. Change Role to "Admin"
5. Save

### Deactivate a Gig
1. Go to `/admin/gigs`
2. Find the gig
3. Click "Toggle Status"
4. Gig will be deactivated

### Handle a Bad Review
1. Go to `/admin/reviews`
2. Find the review
3. Click "Flag" to hide it, or "Delete" to remove
4. Reason: Policy violation, spam, etc.

### Check Order Status
1. Go to `/admin/orders`
2. Filter by status if needed
3. Click order ID to view details
4. Update status if necessary

### Get Monthly Report
1. Go to each section (Users, Gigs, Orders, Reviews)
2. Set date filters if needed
3. Click "Export CSV"
4. Download and analyze in Excel/Sheets

## Dashboard Overview

The dashboard shows key metrics at a glance:

| Metric | Shows | Purpose |
|--------|-------|---------|
| Total Users | Clients + Handymen | Platform growth |
| Total Gigs | Active services | Service diversity |
| Total Orders | All orders | Transaction volume |
| Avg Rating | Platform average | Quality indicator |
| Pending Orders | Waiting status | Service SLA |
| Recent Activity | Latest users/orders/reviews | Monitoring |

## Data Exports

All management sections support CSV export:

**What's Included:**
- Users: Name, email, phone, role, creation date
- Gigs: Title, type, handyman, tier count, status
- Orders: ID, client, gig, status, price, date
- Reviews: Reviewer, gig, rating, comment, status

**Use Cases:**
- Monthly reporting
- Data backup
- External analysis
- Compliance documentation
- Archive records

## Admin Permissions & Security

### What Admins Can Do
✅ View all users, gigs, orders, reviews
✅ Edit and delete user accounts
✅ Manage gig listings and pricing tiers
✅ Monitor and moderate orders
✅ Moderate reviews and flag inappropriate content
✅ Export platform data
✅ View activity logs

### What Admins Cannot Do
❌ Create orders (only clients can)
❌ Create gigs directly (only handymen can)
❌ Access payment information
❌ View user passwords
❌ Override completed orders

### Security Features
- Only users with `role = 'admin'` can access `/admin/*` routes
- Admin middleware validates every request
- Non-admin access returns 403 Forbidden
- All admin actions are logged
- Session management ensures security

## Troubleshooting

### "Access Denied" Error
- Check if your user role is 'admin'
- Try logging out and back in
- Clear browser cache

### Export Shows No Data
- Verify filters aren't too restrictive
- Check if records exist in database
- Try export without filters

### Page Not Loading
- Clear browser cache
- Check internet connection
- Verify admin routes are registered

## Best Practices

1. **Regular Backups** - Export data regularly for safety
2. **Monitor Reviews** - Check flagged reviews weekly
3. **Track Orders** - Watch pending orders for delays
4. **Clean Database** - Periodically remove old test data
5. **Secure Access** - Don't share admin credentials
6. **Document Actions** - Keep notes on major changes

## Support

For questions or issues:
1. Check the full documentation: [ADMIN_INTERFACE_GUIDE.md](ADMIN_INTERFACE_GUIDE.md)
2. Review route definitions: `routes/web.php`
3. Check controller files: `app/Http/Controllers/Admin/`
4. Contact development team for bugs

---

**Your admin interface is now ready to use!** 🚀
