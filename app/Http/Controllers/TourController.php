<?php

namespace App\Http\Controllers;
use App\Models\Tour; // Import the Tour model
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'slots' => 'required|integer',
            'date' => 'required|date',
            'image' => 'required|image',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('tours', 'public');

        $tour = Tour::create(array_merge($validated, ['image' => $imagePath]));

        return response()->json($tour, 201);
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
            'image' => 'sometimes|image',
            'destination_id' => 'sometimes|exists:destinations,id',
        ]);

        if ($request->hasFile('image')) {
            // Handle image upload and delete old one
            Storage::disk('public')->delete($tour->image);
            $validated['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($validated);

        return response()->json($tour);
    }

    // Delete a tour
    public function destroy($id)
    {
        $tour = Tour::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        // Delete the tour image
        Storage::disk('public')->delete($tour->image);
        
        $tour->delete();

        return response()->json(['message' => 'Tour deleted successfully']);
    }
}
