# Authentication

This project uses a custom JWT-based authentication system.
On login, the server returns a token as a cookie named `token`.
A middleware (`TokenVerification`) decodes this token, validates it, and sets the following headers on the request:

- `email`
- `id`
- `role`

All protected routes depend on this header-based user context.
