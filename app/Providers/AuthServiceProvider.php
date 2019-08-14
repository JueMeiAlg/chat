<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //自定义认证
        Auth::viaRequest('chat', function (Request $request) {
            $token = $request->header()['authorization'] ?? null;

            if ($token == null) {
                return null;
            }

            $token = str_replace('Bearer ', '', $token);
            return User::query()->where('token', $token)->first();
        });
        //
    }
}
