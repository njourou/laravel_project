<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Tour;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    // View all bookings
    public function index()
    {
        $bookings = Booking::with('tour')->get();
        return response()->json($bookings);
    }

    // View a specific booking
    public function show($id)
    {
        $booking = Booking::with('tour')->find($id);
        if ($booking) {
            return response()->json($booking);
        }
        return response()->json(['message' => 'Booking not found'], 404);
    }

    // Add a new booking
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'number_of_tickets' => 'required|integer|min:1',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'terms_accepted' => 'required|boolean',
        ]);

        // Retrieve the tour to ensure it exists
        $tour = Tour::find($request->tour_id);

        if (!$tour) {
            return response()->json([
                'message' => 'Tour not found.',
            ], 404);
        }

        // Check if there are enough available slots
        if ($tour->available_slots < $request->number_of_tickets) {
            return response()->json([
                'message' => 'No more tickets left.',
            ], 400);
        }

        // Create a new booking
        $booking = Booking::create([
            'tour_id' => $tour->id,
            'number_of_tickets' => $request->number_of_tickets,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'terms_accepted' => $request->terms_accepted,
        ]);

        // Update the available slots
        $tour->available_slots -= $request->number_of_tickets;
        $tour->save();

        // Load the tour relationship to include in the email
        $booking->load('tour');

        // Send the confirmation email with loaded booking details
        Mail::to($booking->email)->send(new BookingConfirmationMail($booking));

        return response()->json([
            'message' => 'Booking created successfully! A confirmation email has been sent.',
            'booking' => $booking,
        ], 201);
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Validate the incoming request
        $validated = $request->validate([
            'tour_id' => 'sometimes|exists:tours,id',
            'number_of_tickets' => 'sometimes|integer|min:1',
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:15',
            'terms_accepted' => 'sometimes|boolean',
        ]);

        // Check if there are enough available slots if the tour ID or number of tickets is changed
        if (isset($validated['tour_id'])) {
            $tour = Tour::find($validated['tour_id']);

            if (!$tour) {
                return response()->json(['message' => 'Tour not found'], 404);
            }

            if (isset($validated['number_of_tickets']) && $tour->available_slots < $validated['number_of_tickets']) {
                return response()->json(['message' => 'No more tickets left.'], 400);
            }
        }

        $booking->update($validated);

        return response()->json($booking);
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully'], 200);
        }

        return response()->json(['message' => 'Booking not found'], 404);
    }

    // Get the total number of bookings
    public function getTotalBookings()
    {
        $totalBookings = Booking::count();
        return response()->json(['totalBookings' => $totalBookings]);
    }
}
