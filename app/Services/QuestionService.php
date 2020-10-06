<?php

namespace App\Services;

use App\Validators\QuestionValidator;
use App\Exceptions\BadRequestException;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\QuestionRepository;
use App\Repositories\Contracts\CategoryRepository;

class QuestionService
{
    protected $users;
    protected $questions;
    protected $categories;

    public function __construct(QuestionRepository $questions, UserRepository $users, CategoryRepository $categories) 
    {
        $this->users = $users;
        $this->questions = $questions;
        $this->categories = $categories;
    }

    public function create($user_id, $inputs, QuestionValidator $validator) 
    {
        $validator->fire($inputs, 'create');

        $question = $this->questions->createRelationally($this->users->get($user_id), 'questions', [
            'question_text' => \Arr::get($inputs, 'question_text'),
        ]);

        $this->syncCategories($question, \Arr::get($inputs, 'categories'));
        
        return $question;
    }

    public function get($question_id)
    {
        return $this->questions->get($question_id);
    }

    public function getAll()
    {
        return $this->questions->all();
    }
    
    public function update($user_id, $question_id, $inputs, QuestionValidator $validator) 
    {
        $validator->fire($inputs, 'update');

        $question = $this->questions->get($question_id);

        throw_if($question->user_id != $user_id, BadRequestException::class, 'Unable to update question');

        $this->questions->update($question, [
            'question_text' => \Arr::get($inputs, 'question_text')
        ]);

        $this->syncCategories($question, \Arr::get($inputs, 'categories'), true);
    }

    public function delete($user_id, $question_id)
    {
        $question = $this->questions->get($question_id);

        throw_if(($question->user_id != $user_id) || ($question->answers()->count() > 0), BadRequestException::class, 'Unable to delete question');

        $this->questions->delete($question);
    }

    private function syncCategories($question, $category_names, $refresh=false)
    {
        if($refresh){
            $this->questions->sync($question, 'categories', []);
        }

        if($category_names != null && count($category_names) > 0){
            foreach($category_names as $category_name){
                $category = $this->categories->firstOrCreate(['category' => strtolower($category_name)]);
    
                $this->questions->attach($question, 'categories', $category->id);
            }
        }
    }
}
