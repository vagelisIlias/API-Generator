<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketsControllerTest extends TestCase
{   
    use RefreshDatabase;

    public function test_it_can_show_a_generated_ticket_with_status_zero()
    {   
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => false]);
    
        $response = $this->json('get', route('ticket.index', ['status' => 'closed']));
    
        $this->assertFalse($ticket->fresh()->status);

        $response->assertStatus(200);
    }

    public function test_it_can_show_a_generated_ticket_with_status_one()
    {   
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => false]);
    
        $response = $this->json('get', route('ticket.index', ['status' => 'open']));
    
        $this->assertFalse($ticket->fresh()->status);

        $response->assertStatus(200);
    }
}
