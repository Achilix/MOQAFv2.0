# MOQAF Implementation Checklist

## ✅ Completed Tasks

### Backend API Structure

-   [x] API routes created (`routes/api.php`)
-   [x] Authentication controllers (Login, Register, Logout)
-   [x] Resource controllers (Gig, Order, User, Chat)
-   [x] Model relationships updated
-   [x] Sanctum authentication configured
-   [x] CORS configuration file created
-   [x] Database migrations updated for Sanctum

### Documentation

-   [x] API Documentation (`API_DOCUMENTATION.md`)
-   [x] Setup Guide (`SETUP_GUIDE.md`)
-   [x] Frontend Integration Guide (`FRONTEND_INTEGRATION.md`)
-   [x] Backend & Frontend Separation Summary (`BACKEND_FRONTEND_SEPARATION.md`)
-   [x] API Configuration Template (`api-config.js`)

### Configuration

-   [x] `.env.example` updated with proper settings
-   [x] `composer.json` updated with Sanctum
-   [x] CORS configuration for multiple origins
-   [x] Database configuration

---

## ⏳ TODO - Next Steps

### Phase 1: Database Setup (Day 1)

-   [ ] Create MySQL database: `CREATE DATABASE moqaf;`
-   [ ] Update `.env` with database credentials
-   [ ] Run migrations: `php artisan migrate`
-   [ ] Create initial seeders for countries/cities
-   [ ] Test database connection

### Phase 2: Backend Testing (Day 2)

-   [ ] Install Composer dependencies: `composer install`
-   [ ] Test health endpoint: `GET /health`
-   [ ] Test registration endpoint: `POST /auth/register`
-   [ ] Test login endpoint: `POST /auth/login`
-   [ ] Test gigs endpoint: `GET /gigs`
-   [ ] Verify token validation works
-   [ ] Create Postman collection for all endpoints

### Phase 3: Frontend Setup (Day 3-5)

#### Option A: React Web App

-   [ ] Create React app: `npx create-react-app moqaf-frontend`
-   [ ] Install dependencies: `npm install axios react-router-dom`
-   [ ] Setup API client with axios
-   [ ] Create authentication pages (Login, Register)
-   [ ] Create context/state management for auth
-   [ ] Create gig listing page
-   [ ] Create order management page
-   [ ] Create chat interface
-   [ ] Test integration with backend

#### Option B: React Native/Expo (Mobile)

-   [ ] Create Expo app: `npx create-expo-app moqaf-mobile`
-   [ ] Install dependencies: `npm install axios @react-navigation/native`
-   [ ] Setup API client with axios
-   [ ] Create auth screens
-   [ ] Create navigation structure
-   [ ] Implement all API calls
-   [ ] Test on physical device

### Phase 4: Feature Implementation (Week 2+)

#### Authentication & User Management

-   [ ] Registration flow with validation
-   [ ] Login with token storage
-   [ ] Logout with token cleanup
-   [ ] User profile page
-   [ ] Avatar upload
-   [ ] Handyman conversion flow
-   [ ] Password reset (if needed)

#### Gig Management

-   [ ] List gigs with pagination
-   [ ] Search and filter gigs
-   [ ] View gig details
-   [ ] Create gig (handyman only)
-   [ ] Edit gig (handyman only)
-   [ ] Delete gig (handyman only)
-   [ ] Apply to gig
-   [ ] My gigs page

#### Order Management

-   [ ] Create order from gig
-   [ ] List user orders
-   [ ] View order details
-   [ ] Accept order (handyman)
-   [ ] Reject order (handyman)
-   [ ] Complete order (handyman)
-   [ ] Cancel order (client)
-   [ ] Order status tracking

#### Chat/Messaging

-   [ ] Start conversation
-   [ ] List conversations
-   [ ] Send message
-   [ ] Receive message
-   [ ] Message pagination/scrolling
-   [ ] Real-time updates (WebSocket - optional)

### Phase 5: Advanced Features (Week 3+)

-   [ ] Payment integration (Stripe/PayPal)
-   [ ] Rating and review system
-   [ ] Email notifications
-   [ ] Push notifications
-   [ ] Admin dashboard
-   [ ] Advanced search filters
-   [ ] User verification system
-   [ ] Dispute resolution system

---

## Installation & Setup Instructions

### 1. Backend Setup

```bash
# Clone repo
cd MOQAF

# Install PHP dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database
mysql -u root -p
> CREATE DATABASE moqaf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> EXIT;

# Run migrations
php artisan migrate

# Start server
php artisan serve
# Backend runs on http://localhost:8000
```

### 2. Frontend Setup (React Example)

```bash
# Create new React app
npx create-react-app moqaf-frontend
cd moqaf-frontend

# Install dependencies
npm install axios react-router-dom

# Create environment file
echo "REACT_APP_API_URL=http://localhost:8000/api/v1" > .env

# Start development server
npm start
# Frontend runs on http://localhost:3000
```

### 3. Test Backend API

```bash
# Health check
curl http://localhost:8000/api/v1/health

# Register user
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "fname": "John",
    "lname": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'

# Get gigs (with token)
curl http://localhost:8000/api/v1/gigs \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Database Schema Overview

### Users Table

```
id, fname, lname, email, password, phone_number, address, city,
gov_id, photo, email_verified_at, created_at, updated_at
```

### Handyman Table

```
handyman_id (FK users), services (JSON), bio, rating, completed_jobs_count
```

### Gigs Table

```
id_gig, title, type, description, photos (JSON), created_at
```

### Orders Table

```
order_id, client_id (FK users), handyman_id (FK handyman), gig_id (FK gigs),
budget, description, rating, status, created_at, updated_at
```

### Conversations Table

```
id, user1_id (FK users), user2_id (FK users), created_at, updated_at
```

### Messages Table

```
id, conversation_id (FK conversations), sender_id (FK users),
body, created_at, updated_at
```

---

## API Endpoint Summary

| Method | Endpoint                    | Auth | Description      |
| ------ | --------------------------- | ---- | ---------------- |
| POST   | /auth/register              | No   | Register user    |
| POST   | /auth/login                 | No   | Login user       |
| POST   | /auth/logout                | Yes  | Logout user      |
| GET    | /user                       | Yes  | Get current user |
| PUT    | /user/profile               | Yes  | Update profile   |
| POST   | /user/avatar                | Yes  | Upload avatar    |
| POST   | /user/become-handyman       | Yes  | Become handyman  |
| GET    | /gigs                       | No   | List gigs        |
| GET    | /gigs/:id                   | No   | Get gig details  |
| POST   | /gigs                       | Yes  | Create gig       |
| PUT    | /gigs/:id                   | Yes  | Update gig       |
| DELETE | /gigs/:id                   | Yes  | Delete gig       |
| GET    | /my-gigs                    | Yes  | Get user's gigs  |
| POST   | /gigs/:id/apply             | Yes  | Apply to gig     |
| GET    | /orders                     | Yes  | List orders      |
| POST   | /orders                     | Yes  | Create order     |
| GET    | /orders/:id                 | Yes  | Get order        |
| POST   | /orders/:id/accept          | Yes  | Accept order     |
| POST   | /orders/:id/complete        | Yes  | Complete order   |
| POST   | /orders/:id/cancel          | Yes  | Cancel order     |
| POST   | /conversations/start        | Yes  | Start chat       |
| GET    | /conversations              | Yes  | List chats       |
| GET    | /conversations/:id          | Yes  | Get chat         |
| POST   | /conversations/:id/messages | Yes  | Send message     |
| GET    | /conversations/:id/messages | Yes  | Get messages     |
| GET    | /countries                  | No   | Get countries    |
| GET    | /cities/:id                 | No   | Get cities       |

---

## Testing Checklist

### API Testing (with Postman/curl)

-   [ ] Register endpoint returns token
-   [ ] Login endpoint returns token
-   [ ] Logout invalidates token
-   [ ] Public endpoints work without token
-   [ ] Protected endpoints reject requests without token
-   [ ] Token validation works correctly
-   [ ] Error responses are properly formatted

### Frontend Integration Testing

-   [ ] Frontend can register user
-   [ ] Frontend can login and store token
-   [ ] Frontend can fetch gigs
-   [ ] Frontend can create order
-   [ ] Frontend can send messages
-   [ ] Token persists across page refresh
-   [ ] Token is removed on logout
-   [ ] CORS headers are correct

### Mobile Testing (if applicable)

-   [ ] App can authenticate
-   [ ] API calls work on real device
-   [ ] Token storage works
-   [ ] Network requests timeout properly
-   [ ] Error handling is correct

---

## Performance Optimization (Optional)

-   [ ] Add pagination to list endpoints
-   [ ] Add database indexes on frequently queried fields
-   [ ] Implement caching for countries/cities
-   [ ] Add rate limiting to API endpoints
-   [ ] Implement lazy loading for gigs/orders
-   [ ] Add database query optimization
-   [ ] Implement API response compression

---

## Security Checklist

-   [ ] Validate all user inputs
-   [ ] Use prepared statements for queries (Laravel ORM does this)
-   [ ] Implement rate limiting
-   [ ] Use HTTPS in production
-   [ ] Secure token storage (localStorage for web, SecureStore for mobile)
-   [ ] Validate CORS origins
-   [ ] Implement CSRF protection if needed
-   [ ] Hash passwords (Laravel does this by default)
-   [ ] Validate file uploads
-   [ ] Implement authorization checks in controllers

---

## Deployment Checklist (Future)

### Before Going Live

-   [ ] Set `APP_DEBUG=false` in .env
-   [ ] Set `APP_ENV=production` in .env
-   [ ] Generate strong `APP_KEY`
-   [ ] Configure database backups
-   [ ] Setup SSL/HTTPS certificate
-   [ ] Configure CDN for static assets
-   [ ] Setup error logging
-   [ ] Configure email service
-   [ ] Test all endpoints on production
-   [ ] Setup monitoring & alerts

### Database

-   [ ] Run final migrations
-   [ ] Seed initial data (countries, cities)
-   [ ] Create database backups
-   [ ] Test database restore

### Frontend

-   [ ] Build production version
-   [ ] Configure correct API URL
-   [ ] Test all features on production
-   [ ] Optimize images and assets

---

## Common Issues & Solutions

### CORS Errors

-   **Issue**: "Access to XMLHttpRequest blocked by CORS"
-   **Solution**: Check `config/cors.php` and add frontend URL

### Token Not Working

-   **Issue**: 401 Unauthorized on protected endpoints
-   **Solution**: Ensure token is being sent in header: `Authorization: Bearer {token}`

### Database Connection Failed

-   **Issue**: "SQLSTATE[HY000] [2002] Connection refused"
-   **Solution**: Check MySQL is running and `.env` has correct credentials

### Migration Failed

-   **Issue**: "Migration not found"
-   **Solution**: Ensure all migration files exist in `database/migrations/`

### API Not Responding

-   **Issue**: "Connection refused on localhost:8000"
-   **Solution**: Ensure Laravel server is running: `php artisan serve`

---

## Useful Commands Reference

```bash
# Laravel Commands
php artisan serve                    # Start development server
php artisan migrate                  # Run migrations
php artisan migrate:rollback         # Rollback migrations
php artisan migrate:refresh          # Refresh database
php artisan tinker                   # Interactive shell
php artisan route:list               # List all routes
php artisan make:controller           # Create controller
php artisan make:model              # Create model
php artisan test                     # Run tests

# npm Commands
npm start                            # Start React dev server
npm run build                        # Build for production
npm install                          # Install dependencies

# curl Commands
curl http://localhost:8000/api/v1/health  # Health check
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"pass"}'
```

---

## File Reference

-   **Backend Docs**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
-   **Setup Guide**: [SETUP_GUIDE.md](SETUP_GUIDE.md)
-   **Frontend Integration**: [FRONTEND_INTEGRATION.md](FRONTEND_INTEGRATION.md)
-   **Architecture Overview**: [BACKEND_FRONTEND_SEPARATION.md](BACKEND_FRONTEND_SEPARATION.md)
-   **API Configuration**: [api-config.js](api-config.js)

---

## Timeline Estimate

| Phase | Tasks                        | Duration  |
| ----- | ---------------------------- | --------- |
| 1     | Database setup & testing     | 1 day     |
| 2     | Backend API testing          | 1 day     |
| 3     | Frontend setup & integration | 3-5 days  |
| 4     | Core features implementation | 1-2 weeks |
| 5     | Advanced features            | 1-2 weeks |
| 6     | Testing & optimization       | 3-5 days  |
| 7     | Deployment preparation       | 2-3 days  |

**Total: 3-4 weeks** for MVP (Minimum Viable Product)

---

## Next Action

1. **Today**: Run the database setup steps
2. **Tomorrow**: Test all API endpoints with Postman
3. **This Week**: Start building frontend
4. **Next Week**: Implement core features

---
