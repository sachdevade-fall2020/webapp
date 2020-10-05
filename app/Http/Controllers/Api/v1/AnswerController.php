<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\AnswerService;
use App\Http\Controllers\Controller;
use App\Transformers\AnswerTransformer;

class AnswerController extends Controller
{
    protected $answer_service;

    public function __construct(AnswerService $answer_service) {
        $this->answer_service = $answer_service;
    }

    public function create($question_id) {
        $inputs = request()->only([
            'answer_text',
        ]);

        $answer = app()->call([$this->answer_service, 'create'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'inputs'      => $inputs
        ]);

        return response()->json($this->getTransformedData($answer, new AnswerTransformer), 201);
    }

    public function get($question_id, $answer_id) {
        $question = app()->call([$this->answer_service, 'get'], [
            'question_id' => $question_id,
            'answer_id'   => $answer_id
        ]);

        return response()->json($this->getTransformedData($question, new AnswerTransformer));
    }

    public function update($question_id, $answer_id) {
        $inputs = request()->only([
            'answer_text',
        ]);

        app()->call([$this->answer_service, 'update'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'answer_id'   => $answer_id,
            'inputs'      => $inputs
        ]);

        return response()->json([], 204);
    }

    public function delete($question_id, $answer_id) {
        app()->call([$this->answer_service, 'delete'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'answer_id'   => $answer_id
        ]);

        return response()->json([], 204);
    }
}
