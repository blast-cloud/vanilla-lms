<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
            return $user->is_platform_admin == true;
        });
        
        /* define a manager user role */
        Gate::define('isManager', function($user) {
            return $user->manager_id != null;
        });
       
        /* define a student role */
        Gate::define('isStudent', function($user) {
            return $user->student_id != null;
        });

        /* define a lecturer role */
        Gate::define('isLecturer', function($user) {
            return $user->lecturer_id != null;
        });
    }
}
