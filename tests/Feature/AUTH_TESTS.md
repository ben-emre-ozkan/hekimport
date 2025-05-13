# Authentication Tests for Hekimport

This document outlines the authentication test suite implemented in the `AuthenticationTest.php` file.

## Test Coverage

The authentication test suite covers the following areas:

### 1. Basic Authentication

- **Login with correct credentials**: Verifies users can login and are redirected to `/masam`
- **Login with incorrect password**: Validates proper error handling
- **Login with non-existent email**: Validates proper error handling
- **Protected route access**: Ensures unauthenticated users are redirected to login
- **Authenticated route access**: Verifies authenticated users can access protected routes
- **Logout functionality**: Confirms users can log out successfully

### 2. Registration Flow

- **Valid registration**: Tests the entire registration process with valid data
- **Role assignment**: Verifies newly registered users are assigned the 'dentist' role
- **Email validation**: Tests validation of email format during registration
- **Password matching**: Verifies passwords and confirmation must match

### 3. Password Reset Flow

- **Request reset link**: Tests requesting a password reset link
- **Password reset with valid token**: Verifies the password reset process works
- **Password reset with invalid token**: Ensures invalid tokens are rejected

### 4. Session Management

- **Session invalidation on logout**: Verifies sessions are properly invalidated
- **Multiple device login**: Tests that users can be logged in from multiple devices

### 5. Role-Based Access

- **Dentist role redirection**: Tests users with 'dentist' role are redirected to `/masam`
- **Assistant role redirection**: Verifies users with 'assistant' role are also redirected to `/masam`
- **No role access**: Tests that users without specific roles still have basic access

## Test Setup

The test suite uses:

1. **RefreshDatabase trait**: Ensures a clean database for each test
2. **User Factory**: Creates test users with different attributes
3. **Mock notifications**: For testing password reset without sending real emails

## Running the Tests

To run the authentication tests:

```bash
php artisan test tests/Feature/AuthenticationTest.php
```

## Factory Methods

The `UserFactory` has been enhanced with methods to create users with specific roles:

```php
// Create a user with dentist role
$user = User::factory()->asDentist()->create();

// Create a user with assistant role
$user = User::factory()->asAssistant()->create();

// Create a user with admin role
$user = User::factory()->asAdmin()->create();
```

## Test Assertions

The tests use a variety of assertions:

- HTTP response status codes
- Redirects to expected locations
- Authentication status
- Database records
- Session data
- Event dispatching
- Notification sending

## Future Enhancements

Consider adding tests for:

1. **Two-factor authentication**: If enabled in Jetstream
2. **Email verification**: For applications requiring verified email addresses
3. **Social authentication**: If implemented with OAuth providers
4. **API token authentication**: For testing API authentication flows
5. **Impersonation**: If admin users can impersonate other users
6. **Rate limiting**: Tests for login attempt throttling 