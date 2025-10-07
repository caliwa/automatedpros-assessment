<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Http\Requests\Api\UpdateTicketRequest;
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

    /**
     * Update the specified ticket in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->validated());
        return $this->successfulResponse($ticket->fresh(), 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return $this->successfulResponse(null, 'Ticket deleted successfully.', 204);
    }
}