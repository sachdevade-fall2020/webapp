<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Observers\QuestionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Question::observe(QuestionObserver::class);

        Relation::morphMap([
            'questions' => Question::class,
            'answers'   => Answer::class,
        ]);
    }
}
