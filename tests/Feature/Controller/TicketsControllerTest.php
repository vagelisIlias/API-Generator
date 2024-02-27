<?php

namespace Tests\Feature\Controller;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_a_generated_ticket_with_status_zero()
    {
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => false]);
        Ticket::factory()->create(['status' => true]);

        $response = $this->json('get', route('ticket.index', ['status' => 'open']));

        $response->assertStatus(200);

        $content = $response->getOriginalContent();

        $this->assertInstanceOf(LengthAwarePaginator::class, $content);
        $this->assertEquals(1, $content->total());
        $this->assertEquals($ticket->id, $content->first()->id);
    }

    public function test_it_can_show_a_generated_ticket_with_status_one()
    {
        $this->withoutExceptionHandling();

        $ticket = Ticket::factory()->create(['status' => true]);

        $response = $this->json('get', route('ticket.index', ['status' => 'closed']));

        $response->assertStatus(200);
        $content = $response->getOriginalContent();

        $this->assertInstanceOf(LengthAwarePaginator::class, $content);
        $this->assertEquals(1, $content->total());
        $this->assertEquals($ticket->id, $content->first()->id);
    }

    public function test_it_can_show_list_of_tickets_with_corresponding_user_email()
    {
        $this->withoutExceptionHandling();

        $userEmail = 'test@example.com';
        $ticket = Ticket::factory()->create(['user_email' => $userEmail]);

        $response = $this->json('get', route('ticket.user', ['email' => $ticket]));

        $response->assertStatus(200);

        $content = $response->getOriginalContent();

        $this->assertInstanceOf(LengthAwarePaginator::class, $content);

        if (! $content->isEmpty()) {
            $this->assertEquals($userEmail, $content->first()->user_email);
        }
    }

    public function test_it_can_return_the_stats()
    {
        $this->withoutExceptionHandling();

        Ticket::factory()->count(5)->create(['status' => false, 'user_email' => 'most@test.test', 'user_name' => 'Most']);
        Ticket::factory()->count(3)->create(['status' => true, 'user_email' => 'less@test.test', 'user_name' => 'Less']);

        $response = $this->json('get', route('stats'));

        $lastTicket = Ticket::where('status', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        $response->assertStatus(200);

        $this->assertEquals([
            'total_tickets' => 8,
            'unprocessed_tickets' => 5,
            'most_tickets_by_user' => 'Most (5)',
            'last_processed' => $lastTicket?->updated_at,
        ], $response->getOriginalContent());
    }
}
