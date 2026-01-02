# MOQAF Backend & Frontend Separation Summary

## What Has Been Done

### ✅ Backend API Structure Created

#### 1. **API Routes** (`routes/api.php`)

-   Complete REST API with versioning (v1)
-   Public endpoints (gigs listing, country/city data)
-   Protected endpoints (user-only operations)
-   Health check endpoint

#### 2. **API Controllers** (in `app/Http/Controllers/Api/`)

-   **Auth Controllers**:

    -   `LoginController` - User login with token generation
    -   `RegisterController` - User registration
    -   `LogoutController` - Token revocation

-   **Resource Controllers**:
    -   `GigController` - List, create, update, delete gigs; apply to gigs
    -   `OrderController` - Complete order workflow (create, accept, reject, complete, cancel)
    -   `UserController` - User profiles, handyman conversion, file uploads, reference data
    -   `ChatController` - Start conversations, send messages, retrieve chat history

#### 3. **Authentication System**

-   **Laravel Sanctum** integration for token-based auth
-   Bearer token authentication for API requests
-   Token management with automatic expiration
-   No sessions required (stateless API)

#### 4. **Model Relationships**

Updated models with proper relationships:

-   `User` - has conversations, messages, handyman/client profiles
-   `Handyman` - has gigs, orders, user profile
-   `Gig` - has handymen, orders
-   `Order` - belongs to client, handyman, gig
-   `Conversation` - between two users with messages
-   `Message` - sent by user in conversation

#### 5. **Configuration Files**

-   `config/cors.php` - CORS settings for frontend/mobile apps
-   `.env.example` - Updated with proper configuration
-   `api-config.js` - Frontend API configuration template

#### 6. **Documentation**

-   `API_DOCUMENTATION.md` - Complete endpoint reference with examples
-   `SETUP_GUIDE.md` - Installation and development guide
-   `FRONTEND_INTEGRATION.md` - How to integrate frontend apps

#### 7. **Database Migrations**

-   Updated conversations table for user-to-user messaging
-   Added Sanctum personal access tokens table
-   Proper foreign keys and indexes

---

## Architecture Diagram

```
┌─────────────────────────────────────────────┐
│         Frontend/Mobile App                 │
│    (React, Vue, React Native, Flutter)      │
└──────────────┬──────────────────────────────┘
               │ HTTP/HTTPS
               │ (REST API Calls)
               ↓
┌─────────────────────────────────────────────┐
│      MOQAF Backend (Laravel 12)              │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │  API Routes (routes/api.php)         │  │
│  │  - v1/auth/*                         │  │
│  │  - v1/gigs/*                         │  │
│  │  - v1/orders/*                       │  │
│  │  - v1/user/*                         │  │
│  │  - v1/conversations/*                │  │
│  └──────────────────────────────────────┘  │
│                    ↓                         │
│  ┌──────────────────────────────────────┐  │
│  │  API Controllers                     │  │
│  │  ├─ Auth/LoginController             │  │
│  │  ├─ Auth/RegisterController          │  │
│  │  ├─ GigController                    │  │
│  │  ├─ OrderController                  │  │
│  │  ├─ UserController                   │  │
│  │  └─ ChatController                   │  │
│  └──────────────────────────────────────┘  │
│                    ↓                         │
│  ┌──────────────────────────────────────┐  │
│  │  Business Logic (Models)             │  │
│  │  ├─ User                             │  │
│  │  ├─ Handyman                         │  │
│  │  ├─ Gig                              │  │
│  │  ├─ Order                            │  │
│  │  └─ Conversation                     │  │
│  └──────────────────────────────────────┘  │
│                    ↓                         │
│  ┌──────────────────────────────────────┐  │
│  │  Database (MySQL)                    │  │
│  │  ├─ users                            │  │
│  │  ├─ handyman                         │  │
│  │  ├─ gigs                             │  │
│  │  ├─ orders                           │  │
│  │  ├─ conversations                    │  │
│  │  └─ messages                         │  │
│  └──────────────────────────────────────┘  │
└─────────────────────────────────────────────┘
```

---

## How to Use This Setup

### For Backend Development

1. **Setup Backend**:

    ```bash
    cd MOQAF
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan serve
    ```

2. **Test API with Postman**:
    - Import the endpoints from `API_DOCUMENTATION.md`
    - Use `http://localhost:8000/api/v1` as base URL
    - Test endpoints like `GET /gigs`, `POST /auth/login`, etc.

### For Frontend Development (React/Vue Example)

1. **Create React App**:

    ```bash
    npx create-react-app moqaf-frontend
    cd moqaf-frontend
    npm install axios
    ```

2. **Setup API Client**:

    ```javascript
    // src/services/api.js
    import axios from "axios";

    const api = axios.create({
        baseURL: "http://localhost:8000/api/v1",
    });

    // Add token to requests
    api.interceptors.request.use((config) => {
        const token = localStorage.getItem("access_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    });

    export default api;
    ```

3. **Use in Components**:

    ```javascript
    import api from "./services/api";

    // Login
    const response = await api.post("/auth/login", {
        email: "user@example.com",
        password: "password",
    });
    localStorage.setItem("access_token", response.data.access_token);

    // Get gigs
    const gigs = await api.get("/gigs");
    ```

### For Mobile Development (React Native Example)

1. **Create React Native App**:

    ```bash
    npx create-expo-app moqaf-mobile
    cd moqaf-mobile
    npm install axios
    ```

2. **Setup API**:

    ```javascript
    import api from "./services/api";
    import AsyncStorage from "@react-native-async-storage/async-storage";

    // Same as React, but use AsyncStorage instead of localStorage
    ```

---

## API Response Examples

### Authentication Response

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
        "is_handyman": true,
        "is_client": false
    }
}
```

### Resource Response

```json
{
    "data": [
        {
            "id_gig": 1,
            "title": "Fix Electrical Outlet",
            "type": "electrical",
            "description": "Need to fix broken outlet",
            "photos": ["url1", "url2"],
            "created_at": "2026-01-02T..."
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

### Error Response

```json
{
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

---

## Endpoints Available

### Public (No Auth Required)

-   `GET /gigs` - List gigs with search/filter
-   `GET /gigs/{id}` - Get single gig
-   `GET /countries` - Get countries list
-   `GET /cities/{country_id}` - Get cities for country
-   `POST /auth/register` - User registration
-   `POST /auth/login` - User login
-   `GET /health` - Health check

### Protected (Auth Required)

-   `POST /auth/logout` - User logout
-   `GET /user` - Get current user
-   `PUT /user/profile` - Update profile
-   `POST /user/avatar` - Upload avatar
-   `POST /user/become-handyman` - Become handyman
-   `GET /user/handyman-profile` - Get handyman profile
-   `POST /gigs` - Create gig (handyman only)
-   `PUT /gigs/{id}` - Update gig (handyman only)
-   `DELETE /gigs/{id}` - Delete gig (handyman only)
-   `GET /my-gigs` - Get user's gigs
-   `POST /gigs/{id}/apply` - Apply to gig
-   `GET /orders` - List orders
-   `POST /orders` - Create order
-   `GET /orders/{id}` - Get order details
-   `POST /orders/{id}/accept` - Accept order (handyman)
-   `POST /orders/{id}/complete` - Complete order (handyman)
-   `POST /orders/{id}/cancel` - Cancel order (client)
-   `POST /conversations/start` - Start chat
-   `GET /conversations` - List chats
-   `GET /conversations/{id}` - Get chat details
-   `POST /conversations/{id}/messages` - Send message
-   `GET /conversations/{id}/messages` - Get messages

---

## Next Steps

### Immediate

1. ✅ Backend API is ready
2. ⏳ **Setup database** - Run migrations
3. ⏳ **Test API** - Use Postman or curl
4. ⏳ **Build frontend** - Create React/Vue app

### Short Term

1. Create frontend app (React/Vue)
2. Integrate authentication flow
3. Build gig listing page
4. Build order management UI

### Medium Term

1. Payment integration (Stripe, PayPal)
2. Email notifications
3. Push notifications
4. Review/rating system

### Long Term

1. Admin dashboard
2. Analytics
3. Advanced search/filters
4. Real-time updates (WebSockets)
5. Mobile app (React Native/Flutter)

---

## File Structure Summary

```
MOQAF/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Api/
│   │       │   ├── Auth/
│   │       │   │   ├── LoginController.php
│   │       │   │   ├── RegisterController.php
│   │       │   │   └── LogoutController.php
│   │       │   ├── GigController.php
│   │       │   ├── OrderController.php
│   │       │   ├── UserController.php
│   │       │   └── ChatController.php
│   │       └── [Web Controllers - keep for UI if needed]
│   └── Models/
│       ├── User.php (updated with HasApiTokens)
│       ├── Handyman.php (updated relationships)
│       ├── Gig.php
│       ├── Order.php (updated relationships)
│       ├── Conversation.php (updated)
│       └── Message.php
├── routes/
│   ├── api.php (NEW - complete API routes)
│   └── web.php (optional - for web UI)
├── config/
│   ├── cors.php (NEW - CORS configuration)
│   └── [other configs]
├── database/
│   └── migrations/
│       └── [all migrations including Sanctum]
├── API_DOCUMENTATION.md (NEW)
├── SETUP_GUIDE.md (NEW)
├── FRONTEND_INTEGRATION.md (NEW)
├── api-config.js (NEW - frontend config template)
└── .env.example (updated)
```

---

## Token-Based Authentication Flow

```
1. User Registers/Logins
   POST /auth/register or /auth/login
   ↓
2. Backend Returns Access Token
   Response: { "access_token": "...", "user": {...} }
   ↓
3. Frontend Stores Token
   localStorage.setItem('access_token', token)
   ↓
4. Frontend Sends Token with Requests
   GET /user
   Headers: Authorization: Bearer {token}
   ↓
5. Backend Validates Token (Sanctum Middleware)
   ↓
6. Returns Protected Resource
   Response: { "data": {...} }
   ↓
7. On Logout
   POST /auth/logout
   Headers: Authorization: Bearer {token}
   ↓
8. Frontend Removes Token
   localStorage.removeItem('access_token')
```

---

## CORS Configuration

Frontend can connect from these origins:

-   `http://localhost:3000` (React default)
-   `http://localhost:5173` (Vite default)
-   `http://localhost:8000` (Local backend)
-   Custom: Set `FRONTEND_URL` in `.env`

Add more in `config/cors.php`:

```php
'allowed_origins' => [
    'https://yourdomain.com',
    'https://app.yourdomain.com',
],
```

---

## Support & Questions

For specific endpoint details, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
For setup instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md)
For frontend integration, see [FRONTEND_INTEGRATION.md](FRONTEND_INTEGRATION.md)

---
