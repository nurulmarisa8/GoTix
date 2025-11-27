<?php

namespace App\Providers;
use App\Models\Event;
use App\Models\Booking;
use App\Policies\EventPolicy;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider {
    protected $policies = [
        Event::class => EventPolicy::class,
        Booking::class => BookingPolicy::class,
    ];
    
    public function boot(): void {
        $this->registerPolicies();
        
        Gate::define('manage-users', function($user) {
            return $user->role === 'admin';
        });
    }
}
