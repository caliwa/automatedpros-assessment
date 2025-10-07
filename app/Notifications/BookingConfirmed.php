<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your Booking is Confirmed!')
                    ->line('Your booking for the event has been confirmed.')
                    ->line('Booking ID: ' . $this->booking->id)
                    ->action('View Booking', url('/api/bookings'))
                    ->line('Thank you for using our application!');
    }
}