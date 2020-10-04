<?php

namespace App\Repositories\Databases;

use App\Models\Question;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\QuestionRepository as QuestionRepositoryContract;

class QuestionRepository implements QuestionRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = Question::class; 
}