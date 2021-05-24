<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;

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

        Gate::define('isWrite', function (User $user) {
            return $user->type === 'admin' || $user->type === 'author';
        });

        Gate::define('isEdit', function (User $user, $post) {
            return $user->id === $post->user_id || $user->type === 'admin'  ;
        });

        Gate::define('isDelete', function (User $user) {
            return $user->type === 'admin'  ;
        });

    }
}
