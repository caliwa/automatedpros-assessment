<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Models\Event;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage for an event.
     *
     * @param \App\Http\Requests\Api\StoreTicketRequest $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketRequest $request, Event $event)
    {
        $ticketData = $request->toData()->toArray();
        
        $ticket = $event->tickets()->create($ticketData);

        return $this->successfulResponse($ticket, 'Ticket created successfully.', 201);
    }
}