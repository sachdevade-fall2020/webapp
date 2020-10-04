<?php

namespace App\Services;

use App\Validators\QuestionValidator;
use App\Exceptions\BadRequestException;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\QuestionRepository;

class QuestionService
{
    protected $users;
    protected $questions;

    public function __construct(QuestionRepository $questions, UserRepository $users) 
    {
        $this->users = $users;
        $this->questions = $questions;
    }

    public function create($user_id, $inputs, QuestionValidator $validator) 
    {
        $validator->fire($inputs, 'create');

        $question = $this->questions->createRelationally($this->users->get($user_id), 'questions', [
            'question_text' => \Arr::get($inputs, 'question_text'),
        ]);
        
        return $question;
    }

    public function get($question_id)
    {
        return $this->questions->get($question_id);
    }
    
    public function update($user_id, $question_id, $inputs, QuestionValidator $validator) 
    {
        $validator->fire($inputs, 'update');

        $question = $this->questions->get($question_id);

        throw_if($question->user_id != $user_id, BadRequestException::class, 'Unable to update question');

        $this->questions->update($question, [
            'question_text' => \Arr::get($inputs, 'question_text')
        ]);
    }

    public function delete($user_id, $question_id)
    {
        $question = $this->questions->get($question_id);

        throw_if(($question->user_id != $user_id) || ($question->answers()->count() > 0), BadRequestException::class, 'Unable to delete question');

        $this->questions->delete($question);
    }
}
