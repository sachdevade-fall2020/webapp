<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //User
        $this->app->bind(
            \App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\Databases\UserRepository::class
        );

        //Question
        $this->app->bind(
            \App\Repositories\Contracts\QuestionRepository::class,
            \App\Repositories\Databases\QuestionRepository::class
        );

        //Answer
        $this->app->bind(
            \App\Repositories\Contracts\AnswerRepository::class,
            \App\Repositories\Databases\AnswerRepository::class
        );

        //Category
        $this->app->bind(
            \App\Repositories\Contracts\CategoryRepository::class,
            \App\Repositories\Databases\CategoryRepository::class
        );
    }
}
