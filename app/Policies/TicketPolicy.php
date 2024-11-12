<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('IT Agent') && $ticket->department == 'IT') {
            return true;
        }

        if ($user->hasRole('Facilities Agent') && $ticket->department == 'Facilities') {
            return true;
        }

        if ($user->hasRole('Store Manager')) {
            return $user->locations->contains($ticket->location_id);
        }
        
        return false;
    }

}
