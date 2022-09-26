<?php

namespace App\Providers;


use App\Repo\MysqlRepository;
use App\Repo\NotificationInterface;

use App\Services\QueueInterface;
use App\Services\Rabbit\RabbitQueueManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationInterface::class, MysqlRepository::class);
        $this->app->bind(QueueInterface::class, RabbitQueueManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
