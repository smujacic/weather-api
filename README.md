# Weather API

A Laravel REST API for fetching and displaying weather data by city, powered by the OpenWeatherMap API.

## Tech Stack

- PHP 8.2 + Laravel 11
- MySQL 8
- Nginx
- Docker & Docker Compose
- Laravel Sanctum (authentication)
- L5-Swagger (API documentation)

---

## Running Locally

### Prerequisites

- [Docker](https://www.docker.com/products/docker-desktop) and Docker Compose
- [Git](https://git-scm.com/)
- OpenWeatherMap API key — free at [openweathermap.org](https://openweathermap.org/api)

### 1. Clone the repository

```bash
git clone https://github.com/smujacic/weather-api.git
cd weather-api
```

### 2. Set up environment variables

```bash
cp .env.example .env
```

Open `.env` and set the following:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=weatherdb
DB_USERNAME=weather
DB_PASSWORD=weather

OPENWEATHER_API_KEY=your_api_key_here
OPENWEATHER_BASE_URL=https://api.openweathermap.org/data/2.5
```

### 3. Start Docker containers

```bash
docker compose up -d
```

### 4. Install PHP dependencies

```bash
docker compose exec php composer install
```

### 5. Generate application key

```bash
docker compose exec php php artisan key:generate
```

### 6. Run migrations and seeders

```bash
docker compose exec php php artisan migrate --seed
```

### 7. Start the queue worker (for weather fetching)

```bash
docker compose exec php php artisan queue:work
```

> The scheduler that fetches weather data every 10 minutes starts automatically in the `scheduler` container.

---

## Accessing the Application

| Service | URL |
|---|---|
| API | http://localhost:8080/api |
| Swagger documentation | http://localhost:8080/api/documentation |

---

## API Authentication

The API uses Bearer token authentication via Laravel Sanctum.

**Login:**
```bash
curl -X POST http://localhost:8080/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com", "password": "Password123!"}'
```

Use the token from the response in the Authorization header:
```
Authorization: Bearer {token}
```

---

## Available Endpoints

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| POST | `/api/login` | Login | ❌ |
| POST | `/api/logout` | Logout | ✅ |
| GET | `/api/weather` | All weather data (paginated) | ✅ |
| GET | `/api/weather/search?city=Zagreb` | Search by city (last 24h) | ✅ |
| GET | `/api/cities` | List cities | ✅ |
| POST | `/api/cities` | Add a city | ✅ |
| GET | `/api/cities/{id}` | Get a city | ✅ |
| PUT | `/api/cities/{id}` | Update a city | ✅ |
| DELETE | `/api/cities/{id}` | Delete a city | ✅ |
| GET | `/api/users` | List users | ✅ |
| POST | `/api/users` | Create a user | ✅ |
| GET | `/api/users/{id}` | Get a user | ✅ |
| PUT | `/api/users/{id}` | Update a user | ✅ |
| DELETE | `/api/users/{id}` | Delete a user | ✅ |

Full interactive documentation is available at **/api/documentation**.

---

## Generating Swagger Documentation

```bash
docker compose exec php php artisan l5-swagger:generate
```

---

## Useful Docker Commands

```bash
# Stop containers
docker compose down

# Reset the database
docker compose exec php php artisan migrate:fresh --seed

# View logs
docker compose logs -f

# Enter the PHP container
docker compose exec php bash
```
