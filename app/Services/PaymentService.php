<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Exceptions\PaymentFailedException;
use App\Models\Booking;
use App\Models\Payment;
use App\Notifications\BookingConfirmed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process a mock payment for a booking.
     * @param Booking $booking
     * @return Payment
     * @throws PaymentFailedException
     */
    public function processPayment(Booking $booking): Payment
    {
        try {
            return DB::transaction(function () use ($booking) {
                $isSuccessful = rand(1, 100) > 20; // 80% success rate

                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->ticket->price * $booking->quantity,
                    'status' => $isSuccessful ? PaymentStatus::SUCCESS : PaymentStatus::FAILED,
                ]);

                if ($isSuccessful) {
                    $booking->update(['status' => 'confirmed']);
                    $booking->user->notify(new BookingConfirmed($booking));
                } else {
                    $booking->ticket->increment('quantity', $booking->quantity);
                    $booking->update(['status' => 'cancelled']);
                }

                return $payment;
            });
        } catch (\Exception $e) {
            Log::error('Payment processing failed for booking ID: ' . $booking->id, [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new PaymentFailedException('The payment could not be processed.');
        }
    }
}