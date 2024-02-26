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

    public function user(string $email)
    {
        $tickets = Ticket::where('user_email', $email)->paginate();

        return response()->json($tickets);
    }
}
