<?php

namespace App\Observers;

use Log;
use Storage;
use Exception;
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

        Log::info('Deleting files for question id '.$question->id);

        $files = $question->files;

        if($files->count() > 0){
            Storage::deleteDirectory("questions/".$question->id);
            Log::info($files->count()." files deleted");
        }else{
            Log::info('No files found');
        }
    }
}
