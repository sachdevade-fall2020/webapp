<?php

namespace App\Observers;

use Log;
use Storage;
use Exception;
use App\Models\Answer;

use App\Tasks\SendNotification;

class AnswerObserver
{
    /**
     * Handle the answer "created" event.
     *
     * @param  \App\Models\Answer $answer
     * @return void
     */
    public function created(Answer $answer)
    {
        $notifier = app(SendNotification::class);

        $subject = config('settings.sns.subjects.ANSWER_CREATE');

        Log::info('Sending SNS notification with '.$subject.' subject');
        $notifier->handle(config('settings.sns.subjects.ANSWER_CREATE'));
        Log::info('SNS notified successfully');
    }

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

        $notifier = app(SendNotification::class);

        $subject = config('settings.sns.subjects.ANSWER_DELETE');

        Log::info('Sending SNS notification with '.$subject.' subject');
        $notifier->handle($subject);
        Log::info('Sending SNS notification with '.$subject.' subject');
    }
}
