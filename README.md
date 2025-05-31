
# 📘 Contact Management Software Documentation

## 🛠️ Tech Stack

- **Framework**: Laravel 12
- **Frontend**: Vue.js with Inertia.js
- **Database**: MySQL (via Laravel Eloquent)
- **Auth**: OTP-based session authentication
- **Extras**: Excel & PDF export features

---

## 📂 API Routes (`routes/api.php`)

### 🔐 Authentication

| Endpoint             | Method | Description                     |
|----------------------|--------|---------------------------------|
| `/auth/login`        | POST   | Login via email and get OTP    |
| `/auth/verify-otp`   | POST   | Verify OTP for session auth    |
| `/auth/logout`       | GET    | Logout the user (requires auth)|

---

### 📇 Contact Management

| Endpoint                        | Method | Description                     |
|---------------------------------|--------|---------------------------------|
| `/contact/create`              | POST   | Create a new contact            |
| `/contact/list`                | GET    | List all contacts               |
| `/contact/update/{id}`         | POST   | Update contact by ID            |
| `/contact/delete`              | POST   | Delete selected contact(s)      |
| `/contact/deleteAll`           | GET    | Delete all contacts             |
| `/contact/listById`            | GET    | Get contact details by ID       |
| `/contact/latest`              | GET    | Get the latest contact entry    |
| `/contact/count`               | GET    | Get total number of contacts    |

---

### 👤 User Profile

| Endpoint            | Method | Description              |
|---------------------|--------|--------------------------|
| `/profile/create`   | POST   | Create profile info      |
| `/profile/update`   | POST   | Update profile info      |
| `/profile/delete`   | GET    | Delete profile           |
| `/profile/get`      | GET    | Get current user profile |

---

### 👥 User Management

| Endpoint                   | Method | Description                         |
|----------------------------|--------|-------------------------------------|
| `/user/all-user`           | GET    | Get all users                       |
| `/user/user-by-id`         | GET    | Get user by ID                      |
| `/user/all-admin`          | GET    | Get users with role `admin`         |
| `/user/all-editor`         | GET    | Get users with role `editor`        |
| `/user/all-viewer`         | GET    | Get users with role `user`          |
| `/user/count-all`          | GET    | Count all users                     |
| `/user/count-admin`        | GET    | Count admin users                   |
| `/user/count-editor`       | GET    | Count editor users                  |
| `/user/count-viewer`       | GET    | Count viewer users                  |
| `/user/create-user`        | POST   | Create a new user                   |
| `/user/update-role`        | POST   | Update user role                    |
| `/user/delete-user`        | POST   | Delete user                         |

---

### 📤 Contact Excel (Import/Export)

| Endpoint              | Method | Description       |
|-----------------------|--------|-------------------|
| `/contact/export`     | GET    | Export to Excel   |
| `/contact/import`     | POST   | Import from Excel |

---

### 📤 User Excel (Export)

| Endpoint         | Method | Description     |
|------------------|--------|-----------------|
| `/user/export`   | GET    | Export users    |

---

### 🧾 Contact PDF Export

| Endpoint               | Method | Description        |
|------------------------|--------|--------------------|
| `/contact/export-pdf`  | GET    | Export contacts PDF|

---

## 🌐 Web Routes (`routes/web.php`)

### Public Pages

| Route         | Middleware | Description            |
|---------------|------------|------------------------|
| `/LoginForm`  | `guest`    | OTP Login page         |
| `/OtpForm`    | `guest`    | OTP Verification page  |

---

### Authenticated Pages

| Route            | Middleware     | Description               |
|------------------|----------------|---------------------------|
| `/`              | `sessionAuth`  | Home Page                 |
| `/dashboard`     | `sessionAuth`  | Dashboard                 |
| `/contact`       | `sessionAuth`  | Contact management UI     |
| `/userPage`      | `sessionAuth`  | User list/admin panel     |
| `/userProfile`   | `sessionAuth`  | Profile update interface  |

---

## 🗄️ Database Migrations

### `users` Table

| Column        | Type     | Description                         |
|---------------|----------|-------------------------------------|
| `id`          | BIGINT   | Primary Key                         |
| `email`       | STRING   | Unique user email                   |
| `otp`         | STRING   | OTP for login                       |
| `role`        | ENUM     | Role: admin/editor/user (default)   |
| `is_logged_in`| BOOLEAN  | Login status                        |
| `otp_created_at`| TIMESTAMP | When OTP was generated         |
| `created_at`  | TIMESTAMP| Created timestamp                   |
| `updated_at`  | TIMESTAMP| Updated timestamp                   |

---

### `user_profiles` Table

| Column     | Type     | Description                         |
|------------|----------|-------------------------------------|
| `id`       | BIGINT   | Primary Key                         |
| `name`     | STRING   | Full Name                           |
| `email`    | STRING   | Unique                              |
| `phone`    | STRING   | Unique                              |
| `address`  | STRING   | Optional                            |
| `img_url`  | STRING   | Optional profile image              |
| `user_id`  | FK       | Foreign key to `users.id`           |
| `created_at`| TIMESTAMP |                                   |
| `updated_at`| TIMESTAMP |                                   |

---

### `contacts` Table

| Column       | Type    | Description                       |
|--------------|---------|-----------------------------------|
| `id`         | BIGINT  | Primary Key                       |
| `name`       | STRING  | Contact name                      |
| `phone`      | STRING  | Unique phone number               |
| `email`      | STRING  | Unique email                      |
| `address`    | STRING  | Optional                          |
| `nationality`| STRING  | Optional                          |
| `gender`     | ENUM    | male/female/other                 |
| `dob`        | DATE    | Optional                          |
| `designation`| STRING  | Optional                          |
| `created_at` | TIMESTAMP |                                 |
| `updated_at` | TIMESTAMP |                                 |

---

## ✅ Notes

- Ensure **sessionAuth** middleware checks are correctly implemented in `Http\Middleware`.
- OTP mechanism should include **expiration** and **resend logic**.
- All APIs are **RESTful** and follow **CRUD** patterns.
- Excel and PDF features depend on **Maatwebsite/Excel** and **DomPDF** packages.

## License

This project is open-sourced under the [MIT license](LICENSE).

### বাংলা লাইসেন্স (Bangla License)

আপনি এই প্রকল্পটি [MIT লাইসেন্সের অধীনে](LICENSE_BN.txt) ওপেন সোর্স হিসেবে ব্যবহার করতে পারবেন।

> © 2025 Jahid Hasan. All rights reserved.
