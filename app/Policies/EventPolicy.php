<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        return null;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->created_by;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->created_by;
    }
}