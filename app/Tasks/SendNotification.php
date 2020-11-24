<?php

namespace App\Tasks;

use Log;
use Exception;
use Aws\Sns\SnsClient;

class SendNotification
{
    private $client;

    public function __construct()
    {
        $this->client = new SnsClient([
            'version' => '2010-03-31',
            'region' => config('settings.sns.region'),
        ]);
    }

    public function handle($subject, $data)
    {
        Log::info("Sending SNS notification with $subject subject");

        Log::info("Notification Data:");
        Log::info($data);

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
