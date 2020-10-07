<?php

namespace App\Repositories\Databases;

use App\Models\Question;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\QuestionRepository as QuestionRepositoryContract;

class QuestionRepository implements QuestionRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = Question::class;
    
    public function checkCategoryAttached($question, $category){
        $query = $this->query();

        $query->where('id', $question->id);

        return $query->whereHas('categories', function ($q) use($category) {
            $q->where('id', $category->id);
        })->exists();
    }
}