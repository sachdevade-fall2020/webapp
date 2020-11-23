<?php

namespace App\Tasks;

use Aws\Sns\SnsClient;

class SendNotification
{
    private $client;

    public function __construct()
    {
        //
    }

    public function handle($subject)
    {
        // $this->client->publish([
        //     'TopicArn' => config('settings.sns.arn'),
        //     'Message' => json_encode([
        //         'message' => 'Testing SNS',
        //     ]),
        //     'Subject' => $subject
        // ]);
    }
}
