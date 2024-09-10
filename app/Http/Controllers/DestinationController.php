<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DestinationController extends Controller
{
    // Get all destinations
    public function index()
    {
        $destinations = Destination::all();
        return response()->json($destinations);
    }

    // Get a single destination by ID
    public function show($id)
    {
        $destination = Destination::find($id);

        // Log or dd() to debug
        Log::info('Fetching destination with ID: ' . $id);
        if (!$destination) {
            Log::error('Destination with ID ' . $id . ' not found.');
            return response()->json(['message' => 'Destination not found'], 404);
        }

        return response()->json($destination);
    }

    // Create a new destination
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:destinations,slug',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $destination = Destination::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json($destination, 201);
    }

    // Update an existing destination
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:destinations,slug,' . $id,
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $destination = Destination::find($id);

        if ($destination) {
            $destination->name = $request->name;
            $destination->slug = $request->slug;
            $destination->description = $request->description;
            $destination->date = $request->date;
            $destination->save();

            return response()->json($destination);
        } else {
            return response()->json(['message' => 'Destination not found'], 404);
        }
    }

    // Delete a destination by ID
    public function destroy($id)
    {
        $destination = Destination::find($id);

        if ($destination) {
            $destination->delete();
            return response()->json(['message' => 'Destination deleted successfully']);
        } else {
            return response()->json(['message' => 'Destination not found'], 404);
        }
    }


   public function getTotalDestinations()
{
    $totalDestinations = Destination::count();
    return response()->json(['totalDestinations' => $totalDestinations]);
}
    
    
}