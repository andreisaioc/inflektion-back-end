# Inflektion backend task

## How to run the app locally

The app is working with docker locally, so normally you need to just

docker-compose up -d

Then check in docker and run the laravel app.

## Running the command

php artisan app:parse-email-content --output

# API Documentation

This document outlines the available endpoints in our API. For all calls (store, update, getall, etc) you need to use a token, tahts retrieved by mock-token

## 📋 API Routes

### 🔒 Authentication
| Method      | Endpoint                  | Description |
|--------------|---------------------------|---------------|
| `POST`        | `/api/login`              | Login to obtain an authentication token |
| `GET | HEAD` | `/api/mock-token`         | Retrieve a mock token for testing |
| `GET | HEAD` | `/api/user`               | Get authenticated user details |

---

### 📧 Email Management
| Method       | Endpoint                     | Controller & Method                          | Description |
|---------------|-------------------------------|----------------------------------------------------|----------------|
| `POST`         | `/api/emails`                  | `SuccessfulEmailController@store`        | Create a new email |
| `GET | HEAD`  | `/api/emails`                  | `SuccessfulEmailController@getAll`         | Retrieve all emails |
| `GET | HEAD`  | `/api/emails/{id}`            | `SuccessfulEmailController@getById`         | Retrieve a single email by ID |
| `PUT`            | `/api/emails/{id}`            | `SuccessfulEmailController@update`           | Update an email by ID |
| `DELETE`        | `/api/emails/{id}`            | `SuccessfulEmailController@deleteById`     | Delete an email by ID |

---

### 🛠️ System
| Method       | Endpoint                          | Controller & Method | Description |
|---------------|--------------------------------------|-------------------------------|-----------------|
| `GET | HEAD`  | `/`                                      | -                                           | Home route |
| `GET | HEAD`  | `/sanctum/csrf-cookie`          | `CsrfCookieController@show`  | Generate CSRF token |
| `GET | HEAD`  | `/storage/{path}`                     | `storage.local`                              | Access storage files |
| `GET | HEAD`  | `/up`                                     | -                                           | Health check route |

---

### 📄 Usage
1. Clone the repository
2. Install dependencies using `composer install`
3. Run the migrations with `php artisan migrate`
4. Start the development server with `php artisan serve`
5. Access the endpoints as described above

---