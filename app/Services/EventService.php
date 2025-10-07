<?php

namespace App\Services;

use App\Data\EventData;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class EventService
{
    /**
     * Create a new event.
     * @param EventData $data
     * @return Event
     */
    public function createEvent(EventData $data): Event
    {
        $event = Event::create($data->toArray() + ['created_by' => auth()->id()]);
        Cache::tags(['events'])->flush();
        return $event;
    }

    /**
     * Update an existing event.
     * @param Event $event
     * @param EventData $data
     * @return Event
     */
    public function updateEvent(Event $event, EventData $data): Event
    {
        $event->update($data->toArray());
        Cache::tags(['events'])->flush();
        return $event;
    }

    /**
     * Delete an event.
     * @param Event $event
     * @return void
     */
    public function deleteEvent(Event $event): void
    {
        $event->delete();
        Cache::tags(['events'])->flush();
    }
}