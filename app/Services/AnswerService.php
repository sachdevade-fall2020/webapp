<?php

namespace App\Services;

use App\Validators\AnswerValidator;
use App\Exceptions\BadRequestException;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\AnswerRepository;
use App\Repositories\Contracts\QuestionRepository;

class AnswerService
{
    protected $users;
    protected $answers;
    protected $questions;

    public function __construct(QuestionRepository $questions, UserRepository $users, AnswerRepository $answers) 
    {
        $this->users = $users;
        $this->answers = $answers;
        $this->questions = $questions;
    }

    public function create($user_id, $question_id, $inputs, AnswerValidator $validator) 
    {
        $validator->fire($inputs, 'create');

        $question = $this->questions->get($question_id);

        $answer = $this->answers->createRelationally($question, 'answers', [
            'user_id' => $user_id,
            'answer_text' => \Arr::get($inputs, 'answer_text'),
        ]);
        
        return $answer;
    }

    public function get($question_id, $answer_id)
    {
        $question = $this->questions->get($question_id);

        return $this->answers->getWhere('id', $answer_id, ['question_id' => $question->id])->first();
    }
    
    public function update($user_id, $question_id, $answer_id, $inputs, AnswerValidator $validator) 
    {
        $validator->fire($inputs, 'update');

        $answer = $this->get($question_id, $answer_id);

        throw_if($answer->user_id != $user_id, BadRequestException::class, 'Unable to update answer');

        $this->answers->update($answer, [
            'answer_text' => \Arr::get($inputs, 'answer_text')
        ]);
    }

    public function delete($user_id, $question_id, $answer_id)
    {
        $answer = $this->get($question_id, $answer_id);

        throw_if($answer->user_id != $user_id, BadRequestException::class, 'Unable to delete answer');

        $this->answers->delete($answer);
    }
}
