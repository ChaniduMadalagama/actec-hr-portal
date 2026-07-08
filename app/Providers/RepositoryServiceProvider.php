<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Repositories\Eloquent\EloquentJobRepository;
use App\Repositories\Contracts\TimeLogRepositoryInterface;
use App\Repositories\Eloquent\EloquentTimeLogRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(JobRepositoryInterface::class, EloquentJobRepository::class);
        $this->app->bind(TimeLogRepositoryInterface::class, EloquentTimeLogRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
