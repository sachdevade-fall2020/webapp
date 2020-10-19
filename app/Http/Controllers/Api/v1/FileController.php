<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Transformers\FileTransformer;

class FileController extends Controller
{
    protected $file_service;

    /**
     * Create FileController instance.
     * 
     */
    public function __construct(FileService $file_service) 
    {
        $this->file_service = $file_service;
    }

    /**
     * Handle request to create file for a question.
     * 
     */
    public function createQuestionFile($question_id)
    {
        $inputs = request()->only([
            'attachment'
        ]);

        $file = app()->call([$this->file_service, 'createQuestionFile'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'inputs'      => $inputs
        ]);

        return response()->json($this->getTransformedData($file, new FileTransformer), 201);
    }

    /**
     * Handle request to create file for a answer.
     * 
     */
    public function createAnswerFile($question_id, $answer_id)
    {
        $inputs = request()->only([
            'attachment'
        ]);

        $file = app()->call([$this->file_service, 'createAnswerFile'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'answer_id'   => $answer_id,
            'inputs'      => $inputs
        ]);

        return response()->json($this->getTransformedData($file, new FileTransformer), 201);
    }

    /**
     * Handle request to delete file for a question.
     * 
     */
    public function deleteQuestionFile($question_id, $file_id)
    {
        $file = app()->call([$this->file_service, 'deleteQuestionFile'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'file_id'     => $file_id
        ]);

        return response()->json([], 204);
    }

    /**
     * Handle request to answer file for a question.
     * 
     */
    public function deleteAnswerFile($question_id, $answer_id, $file_id)
    {
        $file = app()->call([$this->file_service, 'deleteAnswerFile'], [
            'user_id'     => auth()->user()->id,
            'question_id' => $question_id,
            'answer_id'   => $answer_id,
            'file_id'     => $file_id
        ]);

        return response()->json([], 204);
    }
}
