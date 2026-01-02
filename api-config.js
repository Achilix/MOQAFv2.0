/**
 * API Configuration File
 * Use this file to configure your API client for the MOQAF backend
 * 
 * This is a template for your frontend application
 */

export const API_CONFIG = {
  // Base URL for API - Change this to match your backend
  BASE_URL: process.env.REACT_APP_API_URL || 'http://localhost:8000/api/v1',

  // Timeout for API requests (in milliseconds)
  TIMEOUT: 30000,

  // Token storage key
  TOKEN_KEY: 'access_token',
  USER_KEY: 'user',

  // API Endpoints
  ENDPOINTS: {
    // Auth
    AUTH: {
      REGISTER: '/auth/register',
      LOGIN: '/auth/login',
      LOGOUT: '/auth/logout',
    },

    // Users
    USER: {
      GET_CURRENT: '/user',
      UPDATE_PROFILE: '/user/profile',
      UPLOAD_AVATAR: '/user/avatar',
      BECOME_HANDYMAN: '/user/become-handyman',
      GET_HANDYMAN_PROFILE: '/user/handyman-profile',
      UPDATE_HANDYMAN_PROFILE: '/user/handyman-profile',
    },

    // Gigs
    GIG: {
      LIST: '/gigs',
      GET: '/gigs/:id',
      CREATE: '/gigs',
      UPDATE: '/gigs/:id',
      DELETE: '/gigs/:id',
      MY_GIGS: '/my-gigs',
      APPLY: '/gigs/:id/apply',
    },

    // Orders
    ORDER: {
      LIST: '/orders',
      GET: '/orders/:id',
      CREATE: '/orders',
      UPDATE: '/orders/:id',
      ACCEPT: '/orders/:id/accept',
      REJECT: '/orders/:id/reject',
      COMPLETE: '/orders/:id/complete',
      CANCEL: '/orders/:id/cancel',
    },

    // Chat
    CHAT: {
      START_CONVERSATION: '/conversations/start',
      GET_CONVERSATIONS: '/conversations',
      GET_CONVERSATION: '/conversations/:id',
      GET_MESSAGES: '/conversations/:id/messages',
      SEND_MESSAGE: '/conversations/:id/messages',
    },

    // Reference Data
    REFERENCE: {
      COUNTRIES: '/countries',
      CITIES: '/cities/:country_id',
    },

    // Health
    HEALTH: '/health',
  },

  // Error messages
  ERRORS: {
    NETWORK_ERROR: 'Network error. Please check your connection.',
    TIMEOUT_ERROR: 'Request timeout. Please try again.',
    UNAUTHORIZED_ERROR: 'Your session has expired. Please login again.',
    FORBIDDEN_ERROR: 'You do not have permission to perform this action.',
    NOT_FOUND_ERROR: 'Resource not found.',
    VALIDATION_ERROR: 'Please check your input and try again.',
    SERVER_ERROR: 'Server error. Please try again later.',
  },

  // HTTP Status Codes
  STATUS_CODES: {
    OK: 200,
    CREATED: 201,
    BAD_REQUEST: 400,
    UNAUTHORIZED: 401,
    FORBIDDEN: 403,
    NOT_FOUND: 404,
    UNPROCESSABLE_ENTITY: 422,
    SERVER_ERROR: 500,
  },

  // Order Statuses
  ORDER_STATUSES: {
    PENDING: 'pending',
    ACCEPTED: 'accepted',
    REJECTED: 'rejected',
    COMPLETED: 'completed',
    CANCELLED: 'cancelled',
  },
};

// Default export
export default API_CONFIG;
