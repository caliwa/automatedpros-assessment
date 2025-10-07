<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEventRequest;
use App\Http\Requests\Api\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function __construct(private EventService $eventService)
    {
    }

    public function index(Request $request)
    {
        $cacheKey = 'events.page.' . $request->get('page', 1) . '.' . $request->get('search', '');
        
        $events = Cache::remember($cacheKey, 60, function () use ($request) {
            return Event::query()
                ->with('organizer:id,name')
                ->searchByTitle($request->query('search'))
                ->filterByDate($request->query('date'))
                ->latest()
                ->paginate(10);
        });

        return $this->successfulResponse($events, 'Events retrieved successfully.');
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->createEvent($request->toData());
        return $this->successfulResponse($event, 'Event created successfully.', 201);
    }

    public function show(Event $event)
    {
        $event->load('tickets', 'organizer:id,name,email');
        return $this->successfulResponse($event, 'Event details retrieved.');
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $updatedEvent = $this->eventService->updateEvent($event, $request->toData());
        return $this->successfulResponse($updatedEvent, 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $this->eventService->deleteEvent($event);
        return $this->successfulResponse(null, 'Event deleted successfully.', 204);
    }
}