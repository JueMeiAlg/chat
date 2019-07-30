<?php

namespace App\Providers;

use App\Policy\Login\Contract\LoginInterface;
use App\Policy\Login\NormalLoginPolicy;
use App\Policy\Login\QQLoginPolicy;
use App\Policy\Login\WbLoginPolicy;
use Illuminate\Support\ServiceProvider;

class RegisterPolicyProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //登录策略
        $this->app->singleton(LoginInterface::class, function ($app, $policy) {
            $loginPolicy = [
                'normal' => NormalLoginPolicy::class,
                'wb' => WbLoginPolicy::class,
                'qq' => QQLoginPolicy::class,
                'wx' => WbLoginPolicy::class,
            ];
            if (isset($loginPolicy[$policy['policy']])) {
                return new $loginPolicy[$policy['policy']];
            }
            throw new \Exception('登录策略不存在');
        });
    }
}
