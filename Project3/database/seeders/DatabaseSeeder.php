<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1000)->create();

        //1. we need all the events (generating events with random owners)
        $this->call(EventSeeder::class);

        //2. we need the attendee class to call (we generate attendees for that events
        $this->call(AttendeeSeeder::class);

        //Every user attends 1-3 amount of events
    }
}
