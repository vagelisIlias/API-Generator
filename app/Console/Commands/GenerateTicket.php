<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dummyData = [
            'subject' => fake()->sentence,
            'content' => fake()->paragraph,
            'user_name' => fake()->name,
            'user_email' => fake()->email,
            'created_at' => fake()->dateTime(),
            'status' => false,
        ];

        Ticket::create($dummyData);

        $this->info('Ticket generated successfully!');  
    }
}
