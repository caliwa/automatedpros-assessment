<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Enums\BookingStatus;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Exceptions\PaymentFailedException;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * @param \App\Services\PaymentService $paymentService
     */
    public function __construct(private PaymentService $paymentService)
    {
    }

    /**
     * Process a payment for the specified booking.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== BookingStatus::PENDING) {
            return $this->errorResponse('Payment can only be processed for pending bookings.', 400);
        }

        try {
            $payment = $this->paymentService->processPayment($booking);
            $message = $payment->status->value === 'success' ? 'Payment processed successfully.' : 'Payment failed.';
            
            return $this->successfulResponse($payment, $message);
        } catch (PaymentFailedException $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        return $this->successfulResponse($payment->load('booking.user'), 'Payment details retrieved.');
    }
}