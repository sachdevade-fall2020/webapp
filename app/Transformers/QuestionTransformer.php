<?php

namespace App\Transformers;

use App\Models\Question;

class QuestionTransformer extends Transformer
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
        'answers'
    ];

    /**
    * Turn this item object into a generic array
    *
    * @return array
    */
    public function transform(Question $question)
    {
        return [
            'question_id'       => data_get($question, 'id'),
            'user_id'           => data_get($question, 'user_id'),
            'question_text'     => data_get($question, 'question_text'),
            'created_timestamp' => data_get($question, 'created_timestamp'),
            'updated_timestamp' => data_get($question, 'updated_timestamp'),
        ];
    }

    public function includeAnswers(Question $question)
    {
        return $this->collection($question->answers, new AnswerTransformer);
    }
}
