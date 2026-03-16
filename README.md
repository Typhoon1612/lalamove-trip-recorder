# Lalamove Trip Recorder

A driver portal built with **Laravel 12** and **AWS DynamoDB** for Lalamove drivers in Kuala Lumpur to log trips, track earnings, and export data.

## Features

- **Record Trips** — Log trip date/time, order ID, pickup/drop-off areas, distances, fare, and tolls.
- **Trip Logs** — View all recorded trips with a summary of total earnings, net profit, and completed trip count.
- **Delete Trips** — Remove incorrect entries directly from the trip log.
- **CSV Export** — Download all trip data as a `.csv` file for offline bookkeeping.

## Tech Stack

| Layer     | Technology                         |
| --------- | ---------------------------------- |
| Framework | Laravel 12 (PHP 8.2+)              |
| Database  | AWS DynamoDB                       |
| Frontend  | Blade, Tailwind CSS, Alpine.js     |
| Build     | Vite                               |
| Server    | Laravel Herd / `php artisan serve` |

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

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
