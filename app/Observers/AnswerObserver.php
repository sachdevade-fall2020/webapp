<?php

namespace App\Observers;

use Log;
use Storage;
use Exception;
use App\Models\Answer;

class AnswerObserver
{
    /**
     * Handle the answer "deleting" event.
     *
     * @param  \App\Models\Answer $answer
     * @return void
     */
    public function deleting(Answer $answer)
    {
        Log::info('Deleting files for answer id '.$answer->id);

        $files = $answer->files;

        if($files->count() > 0){
            //db
            foreach ($files as $file) {
                $file->delete();
            }
            //s3
            Storage::deleteDirectory("answers/".$answer->id);
            Log::info($files->count()." files deleted");
        }else{
            Log::info('No files found');
        }
    }
}
