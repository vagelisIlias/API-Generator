<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProcessTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_process_ticket_the_oldest_unprocessed_ticket()
    {
        Ticket::factory()->create([
            'status' => true,
            'created_at' => now()->subYears(2),
        ]);

        $oldTicket = Ticket::factory()->create([
            'created_at' => now()->subYear(),
        ]);

        $newTicket = Ticket::factory()->create([
            'created_at' => now(),
        ]);

        Artisan::call('app:process-ticket');

        $this->assertTrue($oldTicket->fresh()->status);
        $this->assertFalse($newTicket->fresh()->status);
    }
}
