<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $summary = [
            'total_earnings' => 12450.00,
            'net_profit'     => 10820.50,
            'completed'      => 42,
        ];

        $trips = [
            [
                'id'              => 1,
                'order_id'        => 'LLM-8829104',
                'status'          => 'COMPLETED',
                'date'            => 'Oct 24, 2023',
                'time'            => '14:30',
                'pickup'          => 'Central World, Pathum Wan',
                'dropoff'         => 'The Commons, Thong Lo',
                'gross_fare'      => 450.00,
                'net_profit'      => 385.00,
            ],
            [
                'id'              => 2,
                'order_id'        => 'LLM-8829052',
                'status'          => 'COMPLETED',
                'date'            => 'Oct 24, 2023',
                'time'            => '11:15',
                'pickup'          => 'Suvarnabhumi Airport (BKK)',
                'dropoff'         => 'Sukhumvit Soi 11',
                'gross_fare'      => 720.00,
                'net_profit'      => 580.00,
            ],
            [
                'id'              => 3,
                'order_id'        => 'LLM-8828911',
                'status'          => 'COMPLETED',
                'date'            => 'Oct 23, 2023',
                'time'            => '17:45',
                'pickup'          => 'Chatuchak Weekend Market',
                'dropoff'         => 'Ari District',
                'gross_fare'      => 180.00,
                'net_profit'      => 165.00,
            ],
        ];

        return view('trips.index', compact('summary', 'trips'));
    }
}
