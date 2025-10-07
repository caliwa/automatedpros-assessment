<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param \App\Models\User $user
     * @param string $ability
     * @return bool|null
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return bool
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // El usuario puede actualizar el ticket si es el creador del evento al que pertenece el ticket.
        return $user->id === $ticket->event->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Ticket $ticket
     * @return bool
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        // El usuario puede borrar el ticket si es el creador del evento al que pertenece el ticket.
        return $user->id === $ticket->event->created_by;
    }
}