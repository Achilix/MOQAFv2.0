# Frontend Integration Guide

This guide shows how to integrate your frontend (React, Vue, or mobile app) with the MOQAF backend API.

---

## Installation

### For React/Vue Projects

```bash
npm install axios
# or
npm install fetch-api
```

### For React Native / Flutter

Use built-in HTTP clients or install packages:

```bash
npm install axios  # React Native
pub add http     # Flutter
```

---

## Setup API Client

### Option 1: Axios (Recommended)

#### `src/services/api.js` or `utils/api.ts`

```javascript
import axios from "axios";

const API_BASE_URL =
    process.env.REACT_APP_API_URL || "http://localhost:8000/api/v1";

const api = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        "Content-Type": "application/json",
    },
});

// Add token to requests if it exists
api.interceptors.request.use((config) => {
    const token = localStorage.getItem("access_token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Handle responses
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Token expired, redirect to login
            localStorage.removeItem("access_token");
            window.location.href = "/login";
        }
        return Promise.reject(error);
    }
);

export default api;
```

#### `.env`

```
REACT_APP_API_URL=http://localhost:8000/api/v1
```

---

## Authentication Examples

### Register

```javascript
import api from "./api";

export const register = async (userData) => {
    const response = await api.post("/auth/register", {
        fname: userData.firstName,
        lname: userData.lastName,
        email: userData.email,
        password: userData.password,
        password_confirmation: userData.passwordConfirm,
        phone_number: userData.phone,
        city_id: userData.cityId,
    });

    const { access_token } = response.data;
    localStorage.setItem("access_token", access_token);
    localStorage.setItem("user", JSON.stringify(response.data.user));

    return response.data;
};
```

### Login

```javascript
export const login = async (email, password) => {
    const response = await api.post("/auth/login", {
        email,
        password,
    });

    const { access_token, user } = response.data;
    localStorage.setItem("access_token", access_token);
    localStorage.setItem("user", JSON.stringify(user));

    return response.data;
};
```

### Logout

```javascript
export const logout = async () => {
    try {
        await api.post("/auth/logout");
    } finally {
        localStorage.removeItem("access_token");
        localStorage.removeItem("user");
    }
};
```

### Get Current User

```javascript
export const getCurrentUser = async () => {
    const response = await api.get("/user");
    return response.data.data;
};
```

---

## Gig Management Examples

### List All Gigs

```javascript
export const getGigs = async (page = 1, search = "", type = "") => {
    const response = await api.get("/gigs", {
        params: { page, search, type },
    });
    return response.data;
};
```

### Create Gig (Handyman)

```javascript
export const createGig = async (gigData) => {
    const response = await api.post("/gigs", {
        title: gigData.title,
        type: gigData.type,
        description: gigData.description,
        photos: gigData.photos,
    });
    return response.data;
};
```

### Get My Gigs

```javascript
export const getMyGigs = async () => {
    const response = await api.get("/my-gigs");
    return response.data;
};
```

### Apply to Gig

```javascript
export const applyToGig = async (gigId) => {
    const response = await api.post(`/gigs/${gigId}/apply`);
    return response.data;
};
```

---

## Order Management Examples

### Create Order

```javascript
export const createOrder = async (orderData) => {
    const response = await api.post("/orders", {
        gig_id: orderData.gigId,
        handyman_id: orderData.handymanId,
        budget: orderData.budget,
        description: orderData.description,
    });
    return response.data;
};
```

### Get Orders

```javascript
export const getOrders = async (page = 1) => {
    const response = await api.get("/orders", {
        params: { page },
    });
    return response.data;
};
```

### Accept Order (Handyman)

```javascript
export const acceptOrder = async (orderId) => {
    const response = await api.post(`/orders/${orderId}/accept`);
    return response.data;
};
```

### Complete Order (Handyman)

```javascript
export const completeOrder = async (orderId) => {
    const response = await api.post(`/orders/${orderId}/complete`);
    return response.data;
};
```

---

## Chat Examples

### Start Conversation

```javascript
export const startConversation = async (recipientId) => {
    const response = await api.post("/conversations/start", {
        recipient_id: recipientId,
    });
    return response.data;
};
```

### Get Conversations

```javascript
export const getConversations = async (page = 1) => {
    const response = await api.get("/conversations", {
        params: { page },
    });
    return response.data;
};
```

### Send Message

```javascript
export const sendMessage = async (conversationId, message) => {
    const response = await api.post(
        `/conversations/${conversationId}/messages`,
        {
            body: message,
        }
    );
    return response.data;
};
```

### Get Messages

```javascript
export const getMessages = async (conversationId, page = 1) => {
    const response = await api.get(
        `/conversations/${conversationId}/messages`,
        {
            params: { page },
        }
    );
    return response.data;
};
```

---

## User Profile Examples

### Update Profile

```javascript
export const updateProfile = async (profileData) => {
    const response = await api.put("/user/profile", {
        fname: profileData.firstName,
        lname: profileData.lastName,
        phone_number: profileData.phone,
        address: profileData.address,
        city: profileData.cityId,
    });
    return response.data;
};
```

### Upload Avatar

```javascript
export const uploadAvatar = async (file) => {
    const formData = new FormData();
    formData.append("avatar", file);

    const response = await api.post("/user/avatar", formData, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
    return response.data;
};
```

### Become Handyman

```javascript
export const becomeHandyman = async (handymanData) => {
    const response = await api.post("/user/become-handyman", {
        services: handymanData.services,
        bio: handymanData.bio,
    });
    return response.data;
};
```

---

## React Hooks Examples

### Authentication Hook

```javascript
// hooks/useAuth.js
import { useState, useEffect } from "react";
import api from "../services/api";

export const useAuth = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const token = localStorage.getItem("access_token");
                if (token) {
                    const userData = await api.get("/user");
                    setUser(userData.data.data);
                }
            } catch (err) {
                setError(err);
                localStorage.removeItem("access_token");
            } finally {
                setLoading(false);
            }
        };

        fetchUser();
    }, []);

    const login = async (email, password) => {
        const response = await api.post("/auth/login", { email, password });
        localStorage.setItem("access_token", response.data.access_token);
        setUser(response.data.user);
        return response.data;
    };

    const logout = async () => {
        await api.post("/auth/logout");
        localStorage.removeItem("access_token");
        setUser(null);
    };

    return { user, loading, error, login, logout };
};
```

### Usage in Component

```javascript
function App() {
    const { user, loading, login, logout } = useAuth();

    if (loading) return <div>Loading...</div>;

    return (
        <div>
            {user ? (
                <>
                    <p>Welcome, {user.fname}</p>
                    <button onClick={logout}>Logout</button>
                </>
            ) : (
                <LoginForm onLogin={login} />
            )}
        </div>
    );
}
```

---

## Error Handling

```javascript
try {
    const response = await api.post("/orders", orderData);
    // Success
} catch (error) {
    if (error.response?.status === 422) {
        // Validation error
        const errors = error.response.data.errors;
        console.log("Validation errors:", errors);
    } else if (error.response?.status === 403) {
        // Forbidden
        console.log("Not authorized for this action");
    } else if (error.response?.status === 401) {
        // Unauthorized - redirect to login
        window.location.href = "/login";
    } else {
        // Other error
        console.error("Error:", error.message);
    }
}
```

---

## TypeScript Support

```typescript
// types/api.ts
export interface User {
    id: number;
    fname: string;
    lname: string;
    email: string;
    phone_number: string;
    is_handyman: boolean;
    is_client: boolean;
}

export interface Gig {
    id_gig: number;
    title: string;
    type: string;
    description: string;
    photos: string[];
    created_at: string;
}

export interface Order {
    order_id: number;
    client_id: number;
    handyman_id: number;
    gig_id: number;
    budget: number;
    status: "pending" | "accepted" | "completed" | "rejected" | "cancelled";
    created_at: string;
}
```

---

## React Native / Expo Example

```javascript
// For mobile apps
const login = async (email, password) => {
    try {
        const response = await fetch(
            "http://192.168.1.100:8000/api/v1/auth/login",
            {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email, password }),
            }
        );

        const data = await response.json();
        await AsyncStorage.setItem("access_token", data.access_token);
        return data.user;
    } catch (error) {
        console.error("Login failed:", error);
    }
};

const getUser = async () => {
    const token = await AsyncStorage.getItem("access_token");
    const response = await fetch("http://192.168.1.100:8000/api/v1/user", {
        headers: { Authorization: `Bearer ${token}` },
    });
    return await response.json();
};
```

---

## Testing with Postman

1. **Import Collection**:

    - Create a new collection
    - Add requests for each endpoint

2. **Environment Variables**:

    ```
    base_url: http://localhost:8000/api/v1
    token: {{access_token}}
    ```

3. **Sample Request**:
    ```
    GET {{base_url}}/gigs
    Headers: Authorization: Bearer {{token}}
    ```

---

## Troubleshooting

### CORS Error

-   Check `FRONTEND_URL` in `.env`
-   Ensure frontend port is whitelisted in `config/cors.php`

### Token Not Persisting

-   Check if `localStorage` is being used correctly
-   Verify token is being sent in headers

### API Returns 401

-   Token expired - user needs to login again
-   Implement token refresh mechanism

### Request Timeout

-   Check if backend is running
-   Verify API URL is correct
-   Check network connectivity

---

## Next Steps

1. **Setup your frontend project** with this guide
2. **Test with Postman** before building UI
3. **Implement authentication** first
4. **Build features** in order of dependencies
5. **Test on mobile** with actual device

---
