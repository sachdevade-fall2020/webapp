<?php

namespace App\Transformers;

use App\Models\Answer;

class AnswerTransformer extends Transformer
{

    /**
    * constructor
    * @return null
    */
    public function __constructor()
    {
        //
    }

    /**
    * List of resources possible to include
    *
    * @var array
    */
    protected $availableIncludes = [];

    /**
    * List of resources to automatically include
    *
    * @var array
    */
    protected $defaultIncludes = [
        'attachments'
    ];

    /**
    * Turn this item object into a generic array
    *
    * @return array
    */
    public function transform(Answer $answer)
    {
        return [
            'answer_id'         => data_get($answer, 'id'),
            'question_id'       => data_get($answer, 'question_id'),
            'user_id'           => data_get($answer, 'user_id'),
            'answer_text'       => data_get($answer, 'answer_text'),
            'created_timestamp' => data_get($answer, 'created_timestamp'),
            'updated_timestamp' => data_get($answer, 'updated_timestamp'),
        ];
    }

    public function includeAttachments(Answer $answer)
    {
        return $this->collection($answer->attachments, new FileTransformer);
    }
}
