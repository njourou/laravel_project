<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class TourDestinationController extends Controller
{
    /**
     * Get the number of tours booked in each destination.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToursByDestination()
    {
        try {
            // Fetch all destinations
            $destinations = Destination::withCount(['tours as total_tours' => function($query) {
                $query->whereHas('bookings');
            }])->get();

            $result = $destinations->map(function ($destination) {
                return [
                    'destination' => $destination->name,
                    'totalTours' => $destination->total_tours,
                ];
            });

            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Get the total number of tours.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalTours()
    {
        try {
            $totalTours = Tour::count();

            return response()->json(['totalTours' => $totalTours], 200);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 422);
        }
    }
}
