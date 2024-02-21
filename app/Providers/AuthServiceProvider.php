<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define roles and permissions
        Gate::define('access-admin-dashboard', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('access-teacher-dashboard', function ($user) {
            return $user->hasRole('teacher');
        });

        Gate::define('access-student-dashboard', function ($user) {
            return $user->hasRole('student');
        });
    }
    
}
