├── app/
│   ├── Exports/
│   │   ├── ContactsExport.php
│   │   └── UserExport.php
│   ├── Helpers/
│   │   ├── ResponseHelper.php
│   │   └── UploadFileHelper.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Authentication/
│   │   │   │   └── AuthController.php
│   │   │   ├── Contact/
│   │   │   │   └── ContactController.php
│   │   │   ├── Excel/
│   │   │   │   ├── ContactExcelController.php
│   │   │   │   └── UserExcelController.php
│   │   │   ├── Page/
│   │   │   │   ├── AuthenticationPageController.php
│   │   │   │   ├── ContactPageController.php
│   │   │   │   ├── DashboardPageController.php
│   │   │   │   ├── HomePageController.php
│   │   │   │   ├── UserPageController.php
│   │   │   │   └── UserProfilePageController.php
│   │   │   ├── Pdf/
│   │   │   │   └── ContactPdfController.php
│   │   │   ├── User/
│   │   │   │   ├── Controller.php
│   │   │   │   └── UserProfile/
│   │   │   │       └── UserProfileController.php
│   │   ├── Middleware/
│   │   │   ├── HandleInertiaRequests.php
│   │   │   ├── RedirectIfAuthenticated.php
│   │   │   └── SessionAuthenticate.php
│   ├── Imports/
│   │   └── ContactsImport.php
│   ├── Models/
│   │   ├── Contact.php
│   │   ├── User.php
│   │   └── UserProfile.php
│   ├── Notifications/
│   │   └── OTPNotification.php
│   ├── Providers/
│   ├── Service/
│   │   ├── Authentication/
│   │   │   └── AuthService.php
│   │   ├── Contact/
│   │   │   └── ContactService.php
│   │   ├── User/
│   │   │   └── UserService.php
│   │   └── UserProfile/
│   │       └── UserProfileService.php
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_04_13_090958_create_personal_access_tokens_table.php
│   │   ├── 2025_04_13_114926_create_user_profiles_table.php
│   │   ├── 2025_04_13_115042_create_contacts_table.php
│   │   └── 2025_04_21_085545_create_sessions_table.php
│   ├── seeders/
│   │   ├── ContactSeeder.php
│   │   ├── DatabaseSeeder.php
│   │   ├── UserProfileSeeder.php
│   │   └── UserSeeder.php
├── node_modules/
├── public/
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   ├── Components/          # Vue.js components
│   ├── Layouts/             # vue layouts
│   ├── Pages/               # Vue pages
│   ├── utils/               # Utility functions
│   ├── views/               # Laravel Blade views
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
├── .gitignore
└── package.json
