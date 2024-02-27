<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GenerateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_a_ticket()
    {
        $count = Ticket::count();

        Artisan::call('app:generate-ticket');

        $newCount = Ticket::count();

        $this->assertEquals($count + 1, $newCount);
    }

    public function test_it_generates_a_ticket_with_correct_data()
    {
        Artisan::call('app:generate-ticket');

        $lastTicket = Ticket::latest()->first();

        $this->assertNotEmpty($lastTicket->subject);
        $this->assertNotEmpty($lastTicket->content);
        $this->assertNotEmpty($lastTicket->user_name);
        $this->assertNotEmpty($lastTicket->user_email);
        $this->assertFalse($lastTicket->status);
        $this->assertNotEmpty($lastTicket->created_at);
        $this->assertNotEmpty($lastTicket->updated_at);
    }
}
