<?php

namespace App\Repositories\Databases;

use App\Models\Answer;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\AnswerRepository as AnswerRepositoryContract;

class AnswerRepository implements AnswerRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = Answer::class; 
}