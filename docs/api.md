# 📚 Coursify API Documentation

**Version**: 1.0.0  
**Base URL**: `https://api.coursify.local`  
**Authentication**: JWT Bearer Token (optional for public endpoints)  
**Rate Limit**: 60 requests/minute per IP for scraper endpoints

---

## 📋 Table of Contents

1. [Authentication](#authentication)
2. [Courses](#courses)
3. [Enrollments](#enrollments)
4. [Payments](#payments)
5. [Learning Progress](#learning-progress)
6. [Reviews](#reviews)
7. [Certificates](#certificates)
8. [Error Handling](#error-handling)

---

## 🔐 Authentication

All endpoints are public unless specified. Protected endpoints require authentication headers.

### Register User

```http
POST /register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!"
}
```

**Response**:

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "student",
    "created_at": "2026-05-29T12:00:00Z"
}
```

### Login

```http
POST /login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "Password123!"
}
```

**Response**:

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "student"
    },
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

### Logout

```http
POST /logout
Authorization: Bearer {token}
```

---

## 🎓 Courses

### List All Courses

```http
GET /api/courses
```

**Query Parameters**:

```
- page: int (default: 1)
- per_page: int (default: 15, max: 100)
- category: string (filter by category slug)
- difficulty: string (beginner|intermediate|advanced)
- price_min: float
- price_max: float
- rating: float (minimum rating, 1-5)
- search: string (search by title/description)
- language: string (filter by language code)
- sort: string (trending|newest|rating|price_asc|price_desc)
```

**Response**:

```json
{
    "data": [
        {
            "id": 1,
            "title": "Introduction to Web Development",
            "slug": "introduction-to-web-development",
            "description": "Learn web development basics...",
            "price": 499000,
            "currency": "IDR",
            "rating": 4.8,
            "total_ratings": 250,
            "students_enrolled": 1500,
            "image_url": "https://...",
            "instructor": {
                "id": 5,
                "name": "Jane Smith",
                "avatar_url": "https://..."
            },
            "category": "Technology",
            "difficulty": "beginner",
            "duration_hours": 24,
            "has_audit_track": true,
            "created_at": "2026-01-15T10:30:00Z"
        }
    ],
    "pagination": {
        "total": 145,
        "per_page": 15,
        "current_page": 1,
        "last_page": 10
    }
}
```

### Get Course Details

```http
GET /api/courses/{slug}
```

**Response**:

```json
{
    "id": 1,
    "title": "Introduction to Web Development",
    "slug": "introduction-to-web-development",
    "description": "Learn web development basics...",
    "long_description": "This comprehensive course...",
    "price": 499000,
    "certificate_price": 0,
    "currency": "IDR",
    "rating": 4.8,
    "total_ratings": 250,
    "students_enrolled": 1500,
    "image_url": "https://...",
    "prerequisites": ["HTML Basics", "CSS Fundamentals"],
    "learning_outcomes": ["Build responsive websites", "Deploy to production"],
    "instructors": [
        {
            "id": 5,
            "name": "Jane Smith",
            "bio": "...",
            "avatar_url": "https://..."
        }
    ],
    "category": {
        "id": 1,
        "name": "Technology",
        "slug": "technology"
    },
    "difficulty": "beginner",
    "language": "en",
    "duration_hours": 24,
    "has_audit_track": true,
    "upgrade_deadline": 7,
    "sections": [
        {
            "id": 1,
            "title": "Getting Started",
            "lessons": [
                {
                    "id": 1,
                    "title": "Welcome",
                    "type": "video",
                    "duration_minutes": 5,
                    "is_preview": true
                }
            ]
        }
    ],
    "reviews": [
        {
            "id": 1,
            "user": "John Doe",
            "rating": 5,
            "comment": "Great course!",
            "created_at": "2026-05-20T14:00:00Z"
        }
    ],
    "created_at": "2026-01-15T10:30:00Z",
    "updated_at": "2026-05-29T10:30:00Z"
}
```

---

## 📝 Enrollments

### Enroll in Course

```http
POST /api/enrollments
Authorization: Bearer {token}
Content-Type: application/json

{
  "course_id": 1,
  "track": "audit"  // or "verified"
}
```

**Response** (201 Created):

```json
{
    "id": 42,
    "user_id": 1,
    "course_id": 1,
    "type": "audit",
    "status": "active",
    "progress_percent": 0.0,
    "enrolled_at": "2026-05-29T12:30:00Z"
}
```

**Errors**:

```json
{
    "message": "You are already enrolled in this course",
    "code": "ALREADY_ENROLLED"
}
```

### Get My Enrollments

```http
GET /api/me/enrollments
Authorization: Bearer {token}
```

**Query Parameters**:

```
- status: string (active|completed|refunded)
- page: int
```

**Response**:

```json
{
  "data": [
    {
      "id": 42,
      "course": {
        "id": 1,
        "title": "Web Development",
        "slug": "web-development",
        "image_url": "https://..."
      },
      "type": "audit",
      "status": "active",
      "progress_percent": 45.50,
      "enrolled_at": "2026-05-29T12:30:00Z"
    }
  ],
  "pagination": { ... }
}
```

### Upgrade Enrollment

```http
POST /api/enrollments/{enrollment_id}/upgrade
Authorization: Bearer {token}
Content-Type: application/json

{
  "track": "verified"
}
```

**Response** (200 OK):

```json
{
    "id": 42,
    "type": "verified",
    "upgraded_at": "2026-05-29T13:00:00Z",
    "message": "Successfully upgraded to verified track"
}
```

---

## 💳 Payments

### Create Payment

```http
POST /api/payments
Authorization: Bearer {token}
Content-Type: application/json

{
  "course_id": 1,
  "track": "verified",
  "first_name": "John",
  "last_name": "Doe",
  "country": "Indonesia",
  "card_number": "4532015112830366",
  "card_expiry": "12/25",
  "card_cvc": "123",
  "coupon_code": "COURSIFY10"
}
```

**Response** (201 Created):

```json
{
    "id": 1,
    "transaction_id": "CRS-20260529-A1B2C3D4",
    "amount": 449100,
    "original_amount": 499000,
    "discount_amount": 49900,
    "currency": "IDR",
    "method": "kartu_kredit",
    "status": "paid",
    "card_brand": "visa",
    "card_last4": "0366",
    "coupon_code": "COURSIFY10",
    "paid_at": "2026-05-29T13:00:00Z"
}
```

### Get Payment Details

```http
GET /api/payments/{payment_id}
Authorization: Bearer {token}
```

**Response**:

```json
{
    "id": 1,
    "transaction_id": "CRS-20260529-A1B2C3D4",
    "user_id": 1,
    "amount": 449100,
    "currency": "IDR",
    "method": "kartu_kredit",
    "status": "paid",
    "card_brand": "visa",
    "card_last4": "0366",
    "items": [
        {
            "id": 1,
            "course_id": 1,
            "item_type": "course",
            "price": 499000
        }
    ],
    "paid_at": "2026-05-29T13:00:00Z"
}
```

### List My Payments

```http
GET /api/me/payments
Authorization: Bearer {token}
```

---

## 📊 Learning Progress

### Update Lesson Progress

```http
POST /api/lessons/{lesson_id}/progress
Authorization: Bearer {token}
Content-Type: application/json

{
  "position_seconds": 300,
  "is_completed": false
}
```

**Response**:

```json
{
    "id": 1,
    "lesson_id": 1,
    "user_id": 1,
    "is_completed": false,
    "last_position_seconds": 300,
    "updated_at": "2026-05-29T13:05:00Z"
}
```

### Get Course Progress

```http
GET /api/courses/{course_id}/progress
Authorization: Bearer {token}
```

**Response**:

```json
{
    "course_id": 1,
    "total_lessons": 24,
    "completed_lessons": 8,
    "progress_percent": 33.33,
    "lessons": [
        {
            "id": 1,
            "title": "Welcome",
            "is_completed": true,
            "last_position_seconds": 300
        }
    ]
}
```

---

## ⭐ Reviews

### Create Review

```http
POST /api/courses/{course_id}/reviews
Authorization: Bearer {token}
Content-Type: application/json

{
  "rating": 5,
  "comment": "Excellent course! Very comprehensive."
}
```

**Requirements**:

- User must be enrolled in the course
- User must have completed 100% of course lessons
- One review per user per course

**Response** (201 Created):

```json
{
    "id": 1,
    "course_id": 1,
    "user_id": 1,
    "rating": 5,
    "comment": "Excellent course! Very comprehensive.",
    "user": {
        "id": 1,
        "name": "John Doe",
        "avatar_url": "https://..."
    },
    "created_at": "2026-05-29T13:10:00Z"
}
```

### List Course Reviews

```http
GET /api/courses/{course_id}/reviews
```

**Query Parameters**:

```
- page: int
- sort: string (newest|oldest|rating_asc|rating_desc)
```

**Response**:

```json
{
  "data": [ ... ],
  "pagination": { ... }
}
```

### Update Review

```http
PUT /api/reviews/{review_id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "rating": 4,
  "comment": "Updated comment"
}
```

### Delete Review

```http
DELETE /api/reviews/{review_id}
Authorization: Bearer {token}
```

---

## 🏆 Certificates

### Get My Certificates

```http
GET /api/me/certificates
Authorization: Bearer {token}
```

**Response**:

```json
{
    "data": [
        {
            "id": 1,
            "certificate_number": "CERT-2026-05-29-ABC123",
            "course": {
                "id": 1,
                "title": "Web Development",
                "image_url": "https://..."
            },
            "grade": "A",
            "status": "issued",
            "issued_at": "2026-05-29T14:00:00Z",
            "download_url": "https://api.coursify.local/certificates/1/download",
            "verify_url": "https://coursify.local/verify/CERT-2026-05-29-ABC123"
        }
    ]
}
```

### Download Certificate

```http
GET /api/certificates/{certificate_id}/download
Authorization: Bearer {token}
```

**Response**: PDF file

### Verify Certificate (Public)

```http
GET /verify/{certificate_number}
```

**Response**:

```json
{
    "valid": true,
    "certificate_number": "CERT-2026-05-29-ABC123",
    "user_name": "John Doe",
    "course_title": "Web Development",
    "issued_at": "2026-05-29T14:00:00Z",
    "grade": "A"
}
```

---

## ❌ Error Handling

### Error Response Format

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### HTTP Status Codes

| Code    | Meaning              | Example                                 |
| ------- | -------------------- | --------------------------------------- |
| **200** | OK                   | Successful GET/PUT request              |
| **201** | Created              | Successfully created resource           |
| **400** | Bad Request          | Invalid input validation                |
| **401** | Unauthorized         | Missing/invalid authentication token    |
| **403** | Forbidden            | Not permitted to access resource        |
| **404** | Not Found            | Resource does not exist                 |
| **422** | Unprocessable Entity | Validation errors in request            |
| **429** | Too Many Requests    | Rate limit exceeded (scraper endpoints) |
| **500** | Server Error         | Internal server error                   |

### Common Error Codes

```json
{
    "ALREADY_ENROLLED": "User is already enrolled in this course",
    "COURSE_NOT_FOUND": "The requested course does not exist",
    "UPGRADE_DEADLINE_PASSED": "The upgrade deadline for this course has passed",
    "PAYMENT_FAILED": "Payment processing failed. Please try again.",
    "UNAUTHORIZED": "You are not authorized to perform this action",
    "INVALID_CREDENTIALS": "Invalid email or password"
}
```

---

## 📌 Rate Limiting

- **General endpoints**: 100 requests/minute per user
- **Scraper endpoints** (`/api/scrape/*`): 60 requests/minute per IP
- **Authentication endpoints**: 5 attempts/5 minutes (login)

Headers returned with rate limit info:

```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1685355600
```

---

## 🔗 Pagination

All list endpoints return paginated responses:

```json
{
  "data": [ ... ],
  "pagination": {
    "total": 145,
    "per_page": 15,
    "current_page": 1,
    "last_page": 10,
    "from": 1,
    "to": 15
  }
}
```

---

## 📞 Support

For API issues or questions:

- Email: api-support@coursify.local
- Documentation: https://docs.coursify.local
- Status: https://status.coursify.local

---

**Last Updated**: May 29, 2026  
**API Version**: 1.0.0
