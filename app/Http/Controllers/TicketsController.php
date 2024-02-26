<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

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

    public function stats()
    {
        $totalTickets = Ticket::count();
        $unprocessedTickets = Ticket::where('status', false)->count();

        $userWithMostTickets = Ticket::select('user_name', DB::raw('COUNT(user_email) as total'))
            ->groupBy(['user_name', 'user_email'])
            ->orderBy('total', 'desc')
            ->first();
            
        $lastTicket = Ticket::where('status', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json([
            'total_tickets' => $totalTickets,
            'unprocessed_tickets' => $unprocessedTickets,
            'most_tickets_by_user' => $userWithMostTickets->user_name . ' (' . $userWithMostTickets->total . ')',
            'last_processed' => $lastTicket?->updated_at,
        ]);
    }
}
