<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the authenticated user's bookings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with('ticket.event:id,title,date')->latest()->paginate(10);

        return $this->successfulResponse($bookings, 'Bookings retrieved successfully.');
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param \App\Http\Requests\Api\StoreBookingRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookingRequest $request, Ticket $ticket)
    {
        $validated = $request->validated();
        $quantityToBook = $validated['quantity'];

        if ($ticket->quantity < $quantityToBook) {
            return $this->errorResponse('Not enough tickets available.', 400);
        }

        $booking = DB::transaction(function () use ($request, $ticket, $quantityToBook) {
            $ticket->decrement('quantity', $quantityToBook);

            return Booking::create([
                'user_id' => $request->user()->id,
                'ticket_id' => $ticket->id,
                'quantity' => $quantityToBook,
                'status' => BookingStatus::PENDING,
            ]);
        });

        return $this->successfulResponse($booking, 'Booking created successfully.', 201);
    }

    /**
     * Cancel the specified booking.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== BookingStatus::PENDING) {
            return $this->errorResponse('Only pending bookings can be cancelled.', 400);
        }
        
        DB::transaction(function () use ($booking) {
            $booking->ticket()->increment('quantity', $booking->quantity);
            $booking->update(['status' => BookingStatus::CANCELLED]);
            $booking->delete(); // Soft delete the booking
        });

        return $this->successfulResponse(null, 'Booking cancelled successfully.');
    }
}