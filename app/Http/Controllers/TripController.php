<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\DynamoDb\DynamoDbClient; //This brings in our AWS Translator
use Illuminate\Support\Str; // This helps us create a unique ID

class TripController extends Controller
{
    public function index()
    {
        // 1. Wake up the AWS Translator again
        $sdk =  new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // 2. Ask AWS to "Scan" the drawer and give us EVERYTHING inside
        $result = $sdk->scan([
            'TableName' => env('DYNAMODB_TABLE'),
        ]);

        // 3. Put all the tickets into a neat list
        $trips = $result['Items'] ?? []; // If there are no items, we get an empty list instead of an error

        // 4. Set up our blank calculators (starting at zero)
        $totalTrips = count($trips);
        $totalEarning = 0;
        $totalTolls = 0;

        // 5. Look at every single ticket one by one to do the math!
        foreach ($trips as $trip) {
            // DynamoDB stores numbers inside an 'Nn' label.
            // We use floatval () to make sure PHP treats it as a decimal math number.
            $grossFare = floatval($trip['gross_fare']['N'] ?? 0);
            $tolls = floatval($trip['tolls_parking']['N'] ?? 0);

            // Add this tisket's money to our running totals
            $totalEarning += $grossFare;
            $totalTolls += $tolls;
        }

        // 6. Calculate Net Profit (Earnings minus Tolls)
        $totalNetProfit = $totalEarning - $totalTolls;

        // 7. Hand all the tickets and the math answer to the visual page!
        return view('trips.index', [
            'trips' => $trips,
            'summary' => [
                'total_earnings' => $totalEarning,
                'net_profit'     => $totalNetProfit,
                'completed'      => $totalTrips,
            ],
        ]);
    }

    public function store(Request $request) 
    {
        // 1. Validate: Make sure the driver didn't leave anything empty!
        $data = $request->validate([
            'trip_date' => 'required|date',
            'trip_time' => 'required|string',
            'order_id' => 'required|string',
            'pickup_area' => 'required|string',
            'dropoff_area' => 'required|string',
            'distance_to_pickup' => 'required|numeric',
            'delivery_distance' => 'required|numeric',
            'gross_fare' => 'required|numeric',
            'tolls_parking' => 'required|numeric',
        ]);

        // 2. Wake up the AWS Translator 
        $sdk = new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // 3. Prepare the ticket for the cabinet
        $sdk->putItem([
            'TableName' => env('DYNAMODB_TABLE'),
            'Item' => [
                'id' => ['S' => Str::uuid()->toString()], // Unique ID for each trip
                'trip_date' => ['S' => $data['trip_date']],
                'trip_time' => ['S' => $data['trip_time']],
                'order_id' => ['S' => $data['order_id']],
                'pickup_area' => ['S' => $data['pickup_area']],
                'dropoff_area' => ['S' => $data['dropoff_area']],
                'distance_to_pickup' => ['N' => (string)$data['distance_to_pickup']],
                'delivery_distance' => ['N' => (string)$data['delivery_distance']],
                'gross_fare' => ['N' => (string)$data['gross_fare']],
                'tolls_parking' => ['N' => (string)$data['tolls_parking']],
            ],
        ]);

        // 4. Send the driver back to the home page with a green "Success" message!
        return redirect('/')->with('success', 'Trip recorded successfully!');
    }

    public function destroy($id){
        // 1. Wake up the AWS Translator
        $sdk = new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // 2. Tell AWS to delete the ticket with this ID
        $sdk->deleteItem([
            'TableName' => env('DYNAMODB_TABLE'),
            'Key' => [
                'id' => ['S' => $id],
            ],
        ]);

        // 3. Send the driver back to the logs page with a red "Deleted" message!
        return redirect('/trips')->with('success', 'Trip deleted successfully!');
    } 

    public function export() 
    {
        // 1. Wake up the AWS Translator
        $sdk = new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // 2. Ask AWS to "Scan" the drawer and give us EVERYTHING inside
        $result = $sdk->scan([
            'TableName' => env('DYNAMODB_TABLE'),
        ]);
        $trips = $result['Items'] ?? [];

        // 3. Name our new file with today's date
        $fileName = 'lalamove_trips_' . date('Y-m-d') . '.csv';

        // 4. Tell the browser, "Get ready to download a file!"
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        // 5. Build the actual spreadsheet
        $callback = function () use ($trips) {
            $file = fopen('php://output', 'w');

            // Write the column headers in the first row of the spreadsheet
            fputcsv($file, ['Trip Time', 'Order ID', 'Pickup Area', 'Dropoff Area', 'Distance to Pickup (km)', 'Delivery Distance (km)', 'Gross Fare (RM)', 'Tolls & Parking (RM)']);

            // Loop through the tickets and write the data rows
            foreach ($trips as $trip) {
                fputcsv($file, [
                    $trip['trip_time']['S'] ?? '',
                    $trip['order_id']['S'] ?? '',
                    $trip['pickup_area']['S'] ?? '',
                    $trip['dropoff_area']['S'] ?? '',
                    $trip['distance_to_pickup']['N'] ?? '0',
                    $trip['delivery_distance']['N'] ?? '0',
                    $trip['gross_fare']['N'] ?? '0',
                    $trip['tolls_parking']['N'] ?? '0'
                ]);
            }

            fclose($file);
        };

        // 6. Hand the finished package to the drive
        return response()->stream($callback, 200, $headers);
    }}
