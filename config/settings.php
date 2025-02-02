<?php

return [
    'upload_paths' => [
        'question' => 'questions',
        'answer'   => 'answers',
    ],

    'sns' => [
        'arn' => env('AWS_SNS_ARN', ''),
        'region' => env('AWS_DEFAULT_REGION', ''),
        'subjects' => [
            'ANSWER_CREATE' => 'answer.create',
            'ANSWER_UPDATE' => 'answer.update',
            'ANSWER_DELETE' => 'answer.delete'
        ],
    ]
];