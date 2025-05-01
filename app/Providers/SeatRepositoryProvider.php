<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SeatRepository;
use App\Repositories\SeatRepositoryInterface;

class SeatRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SeatRepositoryInterface::class, SeatRepository::class);
    }
}