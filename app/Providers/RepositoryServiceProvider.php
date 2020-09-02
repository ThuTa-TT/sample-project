<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\EmployeeDepPosRepositoryInterface;
use App\Repositories\EmployeeDepPosRepository;
use App\Repositories\Interfaces\PositionRepositoryInterface;
use App\Repositories\PositionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class,EmployeeRepository::class);
        $this->app->bind(EmployeeDepPosRepositoryInterface::class,EmployeeDepPosRepository::class);
         $this->app->bind(PositionRepositoryInterface::class,PositionRepository::class);
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
