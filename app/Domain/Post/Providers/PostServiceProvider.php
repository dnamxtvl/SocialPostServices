<?php

namespace App\Domain\Post\Providers;

use App\Domain\Post\RepositoryInterfaces\IndividualPostRepositoryInterface;
use App\Infrastructure\Repositories\IndividualPostRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IndividualPostRepositoryInterface::class, IndividualPostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\'.class_basename($modelName).'Factory';
        });
    }
}
