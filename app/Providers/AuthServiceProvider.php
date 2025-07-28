<?php

namespace App\Providers;

use App\Models\Cart;
use App\Policies\CartPolicy;
use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Cart::class => CartPolicy::class,
        Course::class => CoursePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
