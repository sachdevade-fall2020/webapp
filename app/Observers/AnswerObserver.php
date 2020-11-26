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
        $subject = config('settings.sns.subjects.ANSWER_CREATE');
        app(SendNotification::class)->handle($subject, $this->getNotificationData($answer));
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
    }

    /**
     * Handle the answer "updated" event.
     *
     * @param  \App\Models\Answer $answer
     * @return void
     */
    public function updated(Answer $answer)
    {
        $subject = config('settings.sns.subjects.ANSWER_UPDATE');
        app(SendNotification::class)->handle($subject, $this->getNotificationData($answer));
    }

    /**
     * Handle the answer "deleted" event.
     *
     * @param  \App\Models\Answer $answer
     * @return void
     */
    public function deleted(Answer $answer)
    {
        $subject = config('settings.sns.subjects.ANSWER_DELETE');
        app(SendNotification::class)->handle($subject, $this->getNotificationData($answer));
    }

    /**
     * Generate data for notification
     * 
     * @param  \App\Models\Answer $answer
     * @return array
     */
    private function getNotificationData(Answer $answer)
    {
        $question = data_get($answer, 'question');

        $data = [
            'question_id'         => data_get($question, 'id'),
            'question_user_name'  => data_get($question, 'user.full_name'),
            'question_user_email' => data_get($question, 'user.username'),
            'question_url'        => route('question.get', ['id' => data_get($question, 'id')]),
            'answer_id'           => data_get($answer, 'id'),
            'answer_user_url'     => route('user.details', ['id' => data_get($answer, 'user.id')]),
            'answer_user_name'    => data_get($answer, 'user.full_name'),
            'answer_user_email'   => data_get($answer, 'user.username'),
            'answer_text'         => data_get($answer, 'answer_text'),
            'answer_url'          => route('answer.get', ['question_id' => data_get($question, 'id'), 'id' => data_get($answer, 'id')]),
        ];

        return $data;
    }
}
