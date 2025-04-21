## **TokenVerification**

**Functionality**  
The `TokenVerification` middleware ensures that only authenticated users with a valid **JWT token** can access protected routes. It checks for the presence of the token in the request cookies, validates it, and extracts user information from the token.

---

**Process**

- **Extract Token**  
  Retrieves the **JWT token** from the request’s cookies (`$request->cookie('token')`).

- **Token Validation**  
  The token is validated using **`JWTToken::verifyToken()`**. If the token is invalid or expired, it catches the exception and returns a **401 Unauthorized** response using `ResponseHelper::Out()`.

- **Token Structure Check**  
  If the decoded token is not an object or does not contain an **email**, the user is redirected to the **login page**.

- **Set Request Headers**  
  If validation succeeds, the user's **email**, **id**, and **role** are set into the request headers for downstream use.

---

**Redirection/Failure**

- **Missing token** → `401 Unauthorized`  
- **Invalid token** → `401 Unauthorized`  
- **Missing user data (e.g., email)** → Redirect to login

---

## **Failure Scenarios**

### **Missing Token**  
No token found in cookies → **401 Unauthorized**

```json
{
  "status": "error",
  "message": "unauthorized"
}
```

### **Invalid Token**  
Token is malformed or expired → **401 Unauthorized**

```json
{
  "status": "error",
  "message": "unauthorized"
}
```

### **Missing User Info**  
Decoded token does not contain **email** → Redirect to **login** route

---

## **AdminVerification**

**Functionality**  
The `AdminVerification` middleware ensures that only authenticated users with the **admin** role can access specific routes. It verifies the JWT token from cookies and checks the user’s role.

---

**Process**

- **Extract Token**  
  Retrieves the **JWT token** from the request’s cookies.

- **Token Validation**  
  The token is verified using **`JWTToken::verifyToken()`**. If the token is invalid or expired, it returns a **401 Unauthorized** response.

- **Role Validation**  
  Checks if the authenticated user has the role **admin**. If the role does not match, access is denied.

---

**Redirection/Failure**

- **Missing token** → `401 Unauthorized`  
- **Invalid token** → `401 Unauthorized`  
- **Role mismatch** → `401 Unauthorized`

---

## **Failure Scenarios**

### **Missing Token**  
No token found in cookies → **401 Unauthorized**

```json
{
  "status": "error",
  "message": "Unauthorized"
}
```

### **Invalid Token**  
Token is malformed or expired → **401 Unauthorized**

```json
{
  "status": "error",
  "message": "Unauthorized"
}
```

### **Invalid Role**  
User role is not **admin** → **401 Unauthorized**

```json
{
  "status": "error",
  "message": "Unauthorized"
}
```
---

## **Middleware Registration**

**File**  
`bootstrap/app.php`

---

**Aliases Defined**

```php
$middleware->alias([
    'admin' => AdminVerification::class,
    'authenticationToken' => TokenVerification::class,
]);
```

- **admin**  
  Alias for `App\Http\Middleware\AdminVerification`  
  Used to restrict routes to only **admin-role users**.

- **authenticationToken**  
  Alias for `App\Http\Middleware\TokenVerification`  
  Ensures only users with a valid **JWT token** can access protected routes.

---

**Usage in Routes**

You can now apply these middleware aliases directly in your route files like so:

```php
Route::middleware(['authenticationToken'])->group(function () {
    // Protected routes that require a valid token
});

Route::middleware(['admin'])->group(function () {
    // Admin-only routes
});
```

---

**Routing Setup Overview**

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

- `web.php` → Web UI routes  
- `api.php` → API endpoints  
- `console.php` → CLI commands  
- `health: /up` → Health check endpoint (great for deployment monitoring)

---

**Summary**  
This setup is **modern, modular, and follows Laravel 11+ conventions** — making your app clean, scalable, and easy for others to understand or extend.

