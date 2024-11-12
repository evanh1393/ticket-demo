<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'Open';
    case PENDING = 'Pending';
    case SOLVED = 'Solved';
    case CLOSED = 'Closed';
}
