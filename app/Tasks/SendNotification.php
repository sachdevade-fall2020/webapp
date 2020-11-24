<?php

namespace App\Tasks;

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

    public function handle($subject)
    {
        $this->client->publish([
            'TopicArn' => config('settings.sns.arn'),
            'Message' => json_encode([
                'message' => 'Testing SNS',
            ]),
            'Subject' => $subject
        ]);
    }
}
