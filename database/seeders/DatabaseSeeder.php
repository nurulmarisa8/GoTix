<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ticketing.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        
        // Create Organizers
        $organizer1 = User::create([
            'name' => 'Event Organizer 1',
            'email' => 'organizer1@ticketing.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organizer_status' => 'approved'
        ]);
        
        $organizer2 = User::create([
            'name' => 'Event Organizer 2',
            'email' => 'organizer2@ticketing.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organizer_status' => 'pending'
        ]);
        
        // Create Regular Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
        
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
        
        // Create Sample Events
        $event1 = Event::create([
            'user_id' => $organizer1->id,
            'name' => 'Tech Conference 2024',
            'description' => 'Join us for an exciting tech conference featuring industry leaders',
            'event_date' => now()->addMonths(2),
            'location' => 'Jakarta Convention Center',
            'image_url' => 'events/sample1.jpg',
            'status' => 'active'
        ]);
        
        $event2 = Event::create([
            'user_id' => $organizer1->id,
            'name' => 'Music Festival',
            'description' => 'Experience amazing live music performances',
            'event_date' => now()->addMonths(1),
            'location' => 'GBK Stadium',
            'image_url' => 'events/sample2.jpg',
            'status' => 'active'
        ]);
        
        // Create Tickets
        Ticket::create([
            'event_id' => $event1->id,
            'ticket_name' => 'Regular',
            'ticket_description' => 'Standard access to conference',
            'price' => 150000,
            'quota' => 100,
            'available_quota' => 100
        ]);
        
        Ticket::create([
            'event_id' => $event1->id,
            'ticket_name' => 'VIP',
            'ticket_description' => 'VIP access with lunch and networking',
            'price' => 300000,
            'quota' => 30,
            'available_quota' => 30
        ]);
        
        Ticket::create([
            'event_id' => $event2->id,
            'ticket_name' => 'General Admission',
            'ticket_description' => 'Access to all performances',
            'price' => 200000,
            'quota' => 500,
            'available_quota' => 500
        ]);
        
        Ticket::create([
            'event_id' => $event2->id,
            'ticket_name' => 'Front Row',
            'ticket_description' => 'Premium seating at front',
            'price' => 450000,
            'quota' => 100,
            'available_quota' => 100
        ]);
    }
}