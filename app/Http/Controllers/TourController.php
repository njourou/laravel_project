<?php

namespace App\Http\Controllers;

use App\Models\Tour; // Import the Tour model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    // View all tours
    public function index()
    {
        $tours = Tour::with('destination')->get();
        return response()->json($tours);
    }

    // View a specific tour
    public function show($id)
    {
        $tour = Tour::with('destination')->find($id);
        if ($tour) {
            return response()->json($tour);
        }
        return response()->json(['message' => 'Tour not found'], 404);
    }

    // Add a new tour
    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'slots' => 'required|integer',
                'date' => 'required|date',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:9000',
                'destination_id' => 'required|exists:destinations,id',
            ]);

            // Handle the image upload
            $imagePath = $request->file('image')->store('tours', 'public');

            // Create the tour record with the validated data and the image path
            $tour = Tour::create(array_merge(
                $validated, 
                ['image' => $imagePath]
            ));

            // Return a successful response with the tour details
            return response()->json([
                'message' => 'Tour created successfully',
                'tour' => $tour,
                'image_url' => asset('storage/' . $imagePath)  // Generate a URL for the image
            ], 201);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error($e);

            // Return an error response
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 422);
        }
    }

    // Edit a tour
    public function update(Request $request, $id)
    {
        $tour = Tour::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'slots' => 'sometimes|integer',
            'date' => 'sometimes|date',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Added mime types and max size
            'destination_id' => 'sometimes|exists:destinations,id',
        ]);

        // Handle image upload and delete old one if a new image is provided
        if ($request->hasFile('image')) {
            if ($tour->image && Storage::disk('public')->exists($tour->image)) {
                Storage::disk('public')->delete($tour->image);
            }
            $validated['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($validated);

        return response()->json($tour);
    }

    // Delete a tour
    public function destroy($id) {
        $tour = Tour::find($id);
        if ($tour) {
            if ($tour->bookings()->exists()) {
                return response()->json(['message' => 'Cannot delete tour with existing bookings'], 400);
            }
            $tour->delete();
            return response()->json(['message' => 'Tour deleted successfully'], 200);
        }
        return response()->json(['message' => 'Tour not found'], 404);
    }
    
    // Get the total number of tours
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
