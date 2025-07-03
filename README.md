# VormiaGuardPHP

**Why VormiaGuardPHP?**

VormiaGuardJS (frontend) enables powerful access control and role-based UI logic, but secure authentication and authorization require backend support. VormiaGuardPHP provides the necessary endpoints (/api/user, /api/can-access) and middleware for Laravel, ensuring your frontend and backend work together securely. Use VormiaGuardPHP with VormiaGuardJS for a complete, secure, full-stack solution.

**VormiaGuardPHP** is a Laravel package providing guard and authentication endpoints, middleware, and utilities for the Vormia ecosystem. It is designed to work with VormiaGuardJS and VormiaQueryJS for full-stack authentication and authorization.

## Features

- Guard endpoints for frontend integration
- Role and permission middleware
- Install, update, uninstall artisan commands
- Checks for Sanctum and Vormia dependencies

## Installation

```bash
composer require vormiaphp/vormiaguardphp
php artisan vormiaguard:install
```

## Commands

- `php artisan vormiaguard:install` – Installs VormiaGuardPHP, checks dependencies
- `php artisan vormiaguard:update` – Updates VormiaGuardPHP setup
- `php artisan vormiaguard:uninstall` – Uninstalls VormiaGuardPHP

## Requirements

- Laravel 9+
- vormiaphp/vormia
- laravel/sanctum

## Endpoints

- `/api/user` – Returns authenticated user info
- `/api/can-access` – Checks if user can access a route (with optional middleware)
- `/login`, `/logout` – Standard Laravel auth endpoints

## Middleware

- Role, permission, and guard middleware for route protection

## Next Steps

1. **Register routes** for `/api/user` and `/api/can-access` in your package's route file (e.g., `routes/api.php`):

   ```php
   use VormiaGuardPhp\Http\Controllers\UserController;
   use VormiaGuardPhp\Http\Controllers\AccessController;

   Route::middleware(['auth:sanctum'])->group(function () {
       Route::get('/user', [UserController::class, 'show']);
       Route::get('/can-access', [AccessController::class, 'canAccess']);
   });
   ```

2. **Register the middleware** in your service provider or via Laravel's middleware aliases (e.g., in `app/Http/Kernel.php`):
   ```php
   protected $routeMiddleware = [
       // ...
       'checkrole' => \VormiaGuardPhp\Http\Middleware\CheckRole::class,
   ];
   ```
3. **(Optional)** Add more middleware for permissions, modules, etc., as needed for your application's requirements.

---

### Laravel Backend: can-access Endpoint Example

Add this route to your Laravel backend to support backend-driven access checks:

```php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

Route::middleware('auth:sanctum')->get('/can-access', function (Request $request) {
    $user = $request->user();
    $route = $request->query('route');
    $middleware = $request->query('middleware');

    // Example: check role middleware
    if ($middleware && str_starts_with($middleware, 'role:')) {
        $role = explode(':', $middleware)[1];
        if (!$user->hasRole($role)) {
            return response()->json(['allowed' => false], 403);
        }
    }

    // Example: check route access (customize as needed)
    if ($route && !$user->canAccessRoute($route)) {
        return response()->json(['allowed' => false], 403);
    }

    return response()->json(['allowed' => true]);
});
```

- Adjust the logic to match your app's authorization needs.
- You can check roles, permissions, or any custom logic.

---

---

For more, see the [examples/](./examples/) directory for full app samples.

### Laravel Backend: VormiaGuardPHP Example

To enable secure backend-driven access control, install and configure [VormiaGuardPHP](https://github.com/vormiaphp/vormiaguardphp) in your Laravel project:

```bash
composer require vormiaphp/vormiaguardphp
php artisan vormiaguard:install
```

Then, register the VormiaGuardPHP routes in your `routes/api.php`:

```php
use VormiaGuardPhp\Http\Controllers\UserController;
use VormiaGuardPhp\Http\Controllers\AccessController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/can-access', [AccessController::class, 'canAccess']);
});
```

And register the middleware in your `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ...
    'checkrole' => \VormiaGuardPhp\Http\Middleware\CheckRole::class,
];
```

VormiaGuardPHP provides the `/api/user` and `/api/can-access` endpoints and guard middleware required for VormiaGuardJS to function securely with your Laravel backend.

## License

MIT
