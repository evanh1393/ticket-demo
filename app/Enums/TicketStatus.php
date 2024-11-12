<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'Open';
    case Pending = 'Pending';
    case Solved = 'Solved';
    case Closed = 'Closed';
}
