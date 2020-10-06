<?php

namespace App\Observers;

use Log;
use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the question "deleting" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function deleting(Question $question)
    {
        Log::info('Removing categories for question id '.$question->id);
        
        $question->categories()->sync([]);

        Log::info('Categories removed');
    }
}
