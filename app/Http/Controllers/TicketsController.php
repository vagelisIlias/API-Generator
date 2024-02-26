<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TicketsController extends Controller
{
    public function index(string $status)
    {
        $tickets = Ticket::where('status', $status == 'closed')->paginate();

        return response()->json($tickets);
    }
}
