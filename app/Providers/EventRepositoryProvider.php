<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryInterface;

class EventRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
    }
}