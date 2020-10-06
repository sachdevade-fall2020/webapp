<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use App\Transformers\QuestionTransformer;

class QuestionController extends Controller
{
    protected $question_service;

    public function __construct(QuestionService $question_service) {
        $this->question_service = $question_service;
    }

    public function create() {
        $inputs = request()->only([
            'question_text',
            'categories',
        ]);

        $question = app()->call([$this->question_service, 'create'], [
            'user_id' => auth()->user()->id,
            'inputs'  => $inputs
        ]);

        return response()->json($this->getTransformedData($question, new QuestionTransformer), 201);
    }

    public function getQuestion($question_id) {
        $question = app()->call([$this->question_service, 'get'], ['question_id' => $question_id]);

        return response()->json($this->getTransformedData($question, new QuestionTransformer));
    }

    public function getAllQuestions() {
        $questions = app()->call([$this->question_service, 'getAll']);

        return response()->json($this->getTransformedCollectionData($questions, new QuestionTransformer));
    }

    public function update($question_id) {
        $inputs = request()->only([
            'question_text',
            'categories',
        ]);

        app()->call([$this->question_service, 'update'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'inputs'      => $inputs
        ]);

        return response()->json([], 204);
    }

    public function delete($question_id) {
        app()->call([$this->question_service, 'delete'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id
        ]);

        return response()->json([], 204);
    }
}
