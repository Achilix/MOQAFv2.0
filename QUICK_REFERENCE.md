# MOQAF Quick Reference Guide

## 🚀 Quick Start

### 1. Start Backend (30 seconds)

```bash
cd MOQAF
php artisan serve
# API available at: http://localhost:8000/api/v1
```

### 2. Test API (30 seconds)

```bash
# Health check
curl http://localhost:8000/api/v1/health

# Should respond with: { "status": "ok", "timestamp": "..." }
```

### 3. Start Frontend

```bash
# For React
npx create-react-app moqaf-frontend
cd moqaf-frontend
npm install axios
npm start
# Frontend available at: http://localhost:3000
```

---

## 📚 Key Files

| File                        | Purpose                     |
| --------------------------- | --------------------------- |
| `routes/api.php`            | All API endpoints           |
| `app/Http/Controllers/Api/` | API logic                   |
| `API_DOCUMENTATION.md`      | Complete API reference      |
| `SETUP_GUIDE.md`            | Detailed setup instructions |
| `FRONTEND_INTEGRATION.md`   | How to connect frontend     |
| `api-config.js`             | Frontend API configuration  |

---

## 🔐 Authentication

### Login & Get Token

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

Response:

```json
{
    "access_token": "1|Hdgk5GNnB8VKP...",
    "token_type": "Bearer",
    "user": { "id": 1, "email": "..." }
}
```

### Use Token in Requests

```bash
curl http://localhost:8000/api/v1/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 📡 Common Endpoints

### Authentication

-   `POST /auth/register` - Create account
-   `POST /auth/login` - Login & get token
-   `POST /auth/logout` - Logout (requires token)

### Gigs

-   `GET /gigs` - List all gigs
-   `GET /gigs?search=keyword` - Search gigs
-   `GET /gigs/{id}` - View gig details
-   `POST /gigs` - Create gig (handyman only)

### Orders

-   `GET /orders` - Your orders
-   `POST /orders` - Create order
-   `POST /orders/{id}/accept` - Accept order (handyman)
-   `POST /orders/{id}/complete` - Complete order (handyman)

### Chat

-   `GET /conversations` - Your conversations
-   `POST /conversations/start` - Start new chat
-   `POST /conversations/{id}/messages` - Send message
-   `GET /conversations/{id}/messages` - Get messages

### User

-   `GET /user` - Get current user
-   `PUT /user/profile` - Update profile
-   `POST /user/avatar` - Upload photo

---

## 🔧 Environment Setup

### `.env` File (Copy from `.env.example`)

```env
APP_NAME=MOQAF
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=moqaf
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE moqaf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate
```

---

## 📦 Frontend Integration (React Example)

### 1. Create API Client

```javascript
// src/services/api.js
import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:8000/api/v1",
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem("access_token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;
```

### 2. Use in Component

```javascript
import api from "./services/api";

// Login
async function handleLogin(email, password) {
    const response = await api.post("/auth/login", { email, password });
    localStorage.setItem("access_token", response.data.access_token);
}

// Get data
async function loadGigs() {
    const response = await api.get("/gigs");
    setGigs(response.data.data);
}
```

---

## 🧪 Testing with Postman

### Import Collection

1. Open Postman
2. Create new request
3. Use endpoints from `API_DOCUMENTATION.md`

### Example Request

```
Method: GET
URL: http://localhost:8000/api/v1/gigs
Headers: Authorization: Bearer YOUR_TOKEN
```

### Example Body (POST)

```json
{
    "fname": "John",
    "lname": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

---

## 🐛 Troubleshooting

| Problem              | Solution                                             |
| -------------------- | ---------------------------------------------------- |
| `Connection refused` | Make sure `php artisan serve` is running             |
| `Database error`     | Check MySQL is running & `.env` credentials          |
| `CORS error`         | Check `FRONTEND_URL` in `.env` and `config/cors.php` |
| `401 Unauthorized`   | Ensure token is in `Authorization` header            |
| `Token not saving`   | Use `localStorage.setItem()` in frontend             |

---

## 📱 For Mobile App (React Native)

```javascript
// Use same API client, but store token differently
import AsyncStorage from '@react-native-async-storage/async-storage';

// Store token
await AsyncStorage.setItem('access_token', token);

// Get token
const token = await AsyncStorage.getItem('access_token');

// Add to requests
api.interceptors.request.use((config) => {
  const token = await AsyncStorage.getItem('access_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
```

---

## 📊 User Roles

### Client

-   Browse gigs
-   Create orders
-   Send messages
-   Rate work

### Handyman

-   Create gigs
-   Accept/reject orders
-   Complete work
-   Send messages

### Becoming Handyman

```bash
curl -X POST http://localhost:8000/api/v1/user/become-handyman \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "services": ["electrical", "plumbing"],
    "bio": "Professional handyman"
  }'
```

---

## 💾 Database Tables

```
users
├── id, fname, lname, email, password, phone_number, address, city, gov_id, photo

handyman
├── handyman_id (FK users), services (JSON), bio, rating, completed_jobs_count

gigs
├── id_gig, title, type, description, photos (JSON), created_at

orders
├── order_id, client_id (FK users), handyman_id (FK handyman), gig_id (FK gigs),
   budget, description, rating, status, created_at, updated_at

conversations
├── id, user1_id (FK users), user2_id (FK users), created_at, updated_at

messages
├── id, conversation_id (FK conversations), sender_id (FK users), body, created_at
```

---

## 🎯 Typical User Flow

```
1. User registers → POST /auth/register
2. User logs in → POST /auth/login (get token)
3. Browse gigs → GET /gigs
4. View gig details → GET /gigs/{id}
5. Create order → POST /orders
6. Chat with handyman → POST /conversations/start
7. Send messages → POST /conversations/{id}/messages
8. Order completed → POST /orders/{id}/complete
9. Logout → POST /auth/logout
```

---

## 🔄 Order Status Flow

```
pending → accepted → completed → rated
   ↓
 rejected
   ↓
 cancelled
```

---

## 📞 Support Resources

1. **API Docs**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
2. **Setup Guide**: [SETUP_GUIDE.md](SETUP_GUIDE.md)
3. **Frontend Guide**: [FRONTEND_INTEGRATION.md](FRONTEND_INTEGRATION.md)
4. **Implementation Checklist**: [IMPLEMENTATION_CHECKLIST.md](IMPLEMENTATION_CHECKLIST.md)
5. **Architecture Overview**: [BACKEND_FRONTEND_SEPARATION.md](BACKEND_FRONTEND_SEPARATION.md)

---

## ⚡ Essential Commands

```bash
# Start development
php artisan serve

# Run migrations
php artisan migrate

# Database reset
php artisan migrate:refresh

# Reset everything
php artisan migrate:refresh --seed

# Clear cache
php artisan cache:clear

# View routes
php artisan route:list

# Interactive shell
php artisan tinker
```

---

## 🎯 What's Ready Now

✅ Complete backend API
✅ Authentication system
✅ All main endpoints
✅ Database models
✅ CORS configuration
✅ Comprehensive documentation

---

## ⏭️ What to Do Next

1. Setup database
2. Run migrations
3. Test API with Postman
4. Build frontend
5. Integrate with backend

**Estimated time**: 3-4 weeks for full MVP

---

## 💡 Pro Tips

-   Use Postman for API testing before building UI
-   Store token in localStorage (web) or SecureStore (mobile)
-   Always include `Authorization: Bearer TOKEN` header
-   Check error responses for validation messages
-   Use pagination for large lists
-   Implement loading states in UI
-   Handle token expiration gracefully

---

**Last Updated**: January 2, 2026
**Backend Status**: Ready for Testing ✅
**Frontend Status**: Ready to Build ⏳

---
