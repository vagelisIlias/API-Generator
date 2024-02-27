<?php

namespace Tests\Feature\Controller;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_a_generated_ticket_with_status_zero()
    {
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => false]);

        $response = $this->json('get', route('ticket.index', ['status' => 'open']));

        $this->assertFalse($ticket->fresh()->status);

        $response->assertStatus(200);
    }

    public function test_it_can_show_a_generated_ticket_with_status_one()
    {
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => true]);

        $response = $this->json('get', route('ticket.index', ['status' => 'closed']));

        $this->assertTrue($ticket->fresh()->status);

        $response->assertStatus(200);
    }

    public function test_it_can_show_list_of_tickets_with_corresponding_user_email()
    {
        $this->withoutExceptionHandling();

        $userEmail = 'test@example.com';
        $ticket = Ticket::factory()->create(['user_email' => $userEmail]);

        $response = $this->json('get', route('ticket.user', ['email' => $ticket]));

        $response->assertStatus(200);
    }

    public function test_it_can_return_the_stats()
    {
        $this->withoutExceptionHandling();

        Ticket::factory()->count(5)->create(['status' => false]);
        Ticket::factory()->count(3)->create(['status' => true]);

        $response = $this->json('get', route('stats'));

        $totalTickets = Ticket::count();
        $unprocessedTickets = Ticket::where('status', false)->count();

        $userWithMostTickets = Ticket::select('user_name', DB::raw('COUNT(user_email) as total'))
            ->groupBy('user_name')
            ->orderBy('total', 'desc')
            ->first();

        $lastTicket = Ticket::where('status', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        $response->assertStatus(200, [
            'total_tickets' => $totalTickets,
            'unprocessed_tickets' => $unprocessedTickets,
            'most_tickets_by_user' => $userWithMostTickets->user_name.' ('.$userWithMostTickets->total.')',
            'last_processed' => $lastTicket?->updated_at,
        ]);
    }
}
