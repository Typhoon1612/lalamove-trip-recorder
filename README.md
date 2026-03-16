# Lalamove Trip Recorder

A driver portal built with **Laravel 12** and **AWS DynamoDB** for Lalamove drivers in Kuala Lumpur to log trips, track earnings, and export data.

## Features

- **Record Trips** — Log trip date/time, order ID, pickup/drop-off areas, distances, fare, and tolls.
- **Trip Logs** — View all recorded trips with a summary of total earnings, net profit, and completed trip count.
- **Delete Trips** — Remove incorrect entries directly from the trip log.
- **CSV Export** — Download all trip data as a `.csv` file for offline bookkeeping.

## Tech Stack

| Layer      | Technology                         |
| ---------- | ---------------------------------- |
| Framework  | Laravel 12 (PHP 8.2+)              |
| Database   | AWS DynamoDB                       |
| Frontend   | Blade, Tailwind CSS, Alpine.js     |
| Build      | Vite                               |
| Server     | Laravel Herd / `php artisan serve` |
| Deployment | Docker + Render                    |

## Prerequisites

- **PHP 8.2+** with the `curl`, `mbstring`, `openssl`, and `xml` extensions.
- **Composer 2**
- **Node.js 18+** and **npm**
- An **AWS account** with a DynamoDB table created. The table's partition key must be `id` (String).

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/lalamove-trip-recorder.git
cd lalamove-trip-recorder
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and fill in the AWS section:

```dotenv
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=ap-southeast-1
DYNAMODB_TABLE=your-dynamodb-table-name
```

### 4. Run database migrations (sessions / cache)

```bash
php artisan migrate
```

### 5. Build frontend assets

```bash
npm run build        # production
# or
npm run dev          # development with HMR
```

### 6. Start the server

```bash
php artisan serve
```

Visit `http://localhost:8000` to record your first trip.

## Project Structure

```
app/Http/Controllers/
├── HomeController.php      # Renders the trip entry form
├── TripController.php      # CRUD operations against DynamoDB
routes/
├── web.php                 # All route definitions
resources/views/
├── layouts/app.blade.php   # Shared layout (header, nav)
├── home.blade.php          # Trip entry form
├── trips/index.blade.php   # Trip log with summary cards
```

## Routes

| Method | URI             | Controller Action        | Description         |
| ------ | --------------- | ------------------------ | ------------------- |
| GET    | `/`             | `HomeController@index`   | Trip entry form     |
| GET    | `/trips`        | `TripController@index`   | Trip log & summary  |
| POST   | `/trips/store`  | `TripController@store`   | Save a new trip     |
| DELETE | `/trips/{id}`   | `TripController@destroy` | Delete a trip       |
| GET    | `/trips/export` | `TripController@export`  | Download CSV export |
| GET    | `/ping`         | _(closure)_              | Keep-alive endpoint |

## DynamoDB Item Schema

| Attribute            | Type | Description                 |
| -------------------- | ---- | --------------------------- |
| `id`                 | S    | UUID (partition key)        |
| `trip_date`          | S    | ISO date (`YYYY-MM-DD`)     |
| `trip_time`          | S    | 24-hour time (`HH:MM`)      |
| `order_id`           | S    | Lalamove order reference    |
| `pickup_area`        | S    | Pickup location name        |
| `dropoff_area`       | S    | Drop-off location name      |
| `distance_to_pickup` | N    | Distance to pickup in km    |
| `delivery_distance`  | N    | Delivery distance in km     |
| `gross_fare`         | N    | Gross fare in RM            |
| `tolls_parking`      | N    | Tolls & parking costs in RM |
| `status`             | S    | Always `COMPLETED`          |

## Deployment (Render + Docker)

The app ships with a `Dockerfile` for container-based deployment on [Render](https://render.com).

### Environment variables to set in Render

Set these in your Render service **Environment** tab:

| Variable                | Where      | Value                                       |
| ----------------------- | ---------- | ------------------------------------------- |
| `APP_KEY`               | Secret     | Output of `php artisan key:generate --show` |
| `APP_URL`               | Variable   | `https://your-app.onrender.com`             |
| `APP_ENV`               | Variable   | `production`                                |
| `APP_DEBUG`             | Variable   | `false`                                     |
| `AWS_ACCESS_KEY_ID`     | **Secret** | Your IAM access key                         |
| `AWS_SECRET_ACCESS_KEY` | **Secret** | Your IAM secret key                         |
| `AWS_DEFAULT_REGION`    | Variable   | `ap-southeast-1`                            |
| `DYNAMODB_TABLE`        | Variable   | `lalamove_trips`                            |

> **Never commit real AWS credentials** to the repository. Use Render's secret environment variables or AWS IAM roles.

### Render service settings

| Setting       | Value                           |
| ------------- | ------------------------------- |
| Runtime       | Docker                          |
| Dockerfile    | `./Dockerfile`                  |
| Start command | _(defined in Dockerfile `CMD`)_ |
| Port          | `10000` (or `$PORT`)            |

### Keep-alive scheduler (prevent free-tier spin-down)

The Laravel scheduler pings `/ping` every 14 minutes to keep the Render free-tier instance awake.  
To enable it, add a **Background Worker** service on Render pointing to the same repo with the start command:

```bash
php artisan schedule:work
```

Or run it alongside the web process in a single service:

```bash
php artisan schedule:work & php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
```

### Build & run locally with Docker

```bash
docker build -t lalamove-trip-recorder .
docker run -p 8000:10000 \
  -e APP_KEY=your-app-key \
  -e AWS_ACCESS_KEY_ID=your-key \
  -e AWS_SECRET_ACCESS_KEY=your-secret \
  -e AWS_DEFAULT_REGION=ap-southeast-1 \
  -e DYNAMODB_TABLE=lalamove_trips \
  lalamove-trip-recorder
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
