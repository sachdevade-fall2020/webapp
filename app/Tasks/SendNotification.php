<?php

namespace App\Tasks;

use Log;
use Exception;
use Aws\Sns\SnsClient;

class SendNotification
{
    private $client;

    private $email_subjects;

    public function __construct()
    {
        $this->client = new SnsClient([
            'version' => '2010-03-31',
            'region' => config('settings.sns.region'),
        ]);

        $this->email_subjects = [
            config('settings.sns.subjects.ANSWER_CREATE') => 'Create Answer Notification',
            config('settings.sns.subjects.ANSWER_UPDATE') => 'Update Answer Notification',
            config('settings.sns.subjects.ANSWER_DELETE') => 'Delete Answer Notification'
        ];

        $this->actions = [
            config('settings.sns.subjects.ANSWER_CREATE') => 'created',
            config('settings.sns.subjects.ANSWER_UPDATE') => 'updated',
            config('settings.sns.subjects.ANSWER_DELETE') => 'deleted',
        ];
    }

    public function handle($subject, $data)
    {
        Log::info("Sending SNS notification with $subject subject");

        $data['event'] = $subject;
        
        $data['email_body'] = view('mails.notification')->with([
            'question_url' => $data['question_url'],
            'answer_url'   => $data['answer_url'],
            'action'       => $this->actions[$subject],
        ])->render();

        $data['email_subject'] = $this->email_subjects[$subject];
        
        Log::info("SNS Message - START");
        Log::info($data);
        Log::info("SNS Message - END");

        try{
            $this->client->publish([
                'TopicArn' => config('settings.sns.arn'),
                'Subject'  => $subject,
                'Message'  => json_encode($data),
            ]);

            Log::info('SNS notified successfully');
        }catch(Exception $e){
            Log::error('SNS notification failed');
            Log::error($e->getMessage());
        } 
    }
}
