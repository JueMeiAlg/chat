<?php

namespace App\Providers;

use App\Service\Search\User\Contract\SearchUserInterface;
use App\Service\Search\User\ElasticSearchDriver;
use App\Service\Search\User\MysqlSearchDriver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 延迟加载
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //绑定搜索用户服务
        $this->app->singleton(SearchUserInterface::class, function ($app, $driver) {
            //默认值
            $useDriver = config('app.search.useDriver');
            if (isset($driver['driver'])) {
                $useDriver = $driver['driver'];
            }
            switch ($useDriver) {
                case "mysql":
                    return new MysqlSearchDriver();
                case "elastic":
                    return new ElasticSearchDriver();
                default:
                    throw  new \Exception(sprintf('目前使用的:%s类型的搜索驱动不存在请确认!', $useDriver));
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * 延迟加载绑定
     *
     * @return array
     */
    public function provides()
    {
        return [

        ];
    }
}
