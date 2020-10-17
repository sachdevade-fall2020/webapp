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

        $file = app()->call([$this->file_service, 'create'], [
            'user_id'     => auth()->user()->id,
            'fileable_id' => $question_id,
            'type'        => 'question',
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

        $file = app()->call([$this->file_service, 'create'], [
            'user_id'     => auth()->user()->id,
            'fileable_id' => $answer_id,
            'type'        => 'answer',
            'inputs'      => $inputs
        ]);

        return response()->json($this->getTransformedData($file, new FileTransformer), 201);
    }

    /**
     * Handle request to delete file for a question.
     * 
     */
    public function deleteQuestionFile($fileable_id, $file_id)
    {
        $file = app()->call([$this->file_service, 'delete'], [
            'user_id'     => auth()->user()->id,
            'fileable_id' => $fileable_id,
            'file_id'     => $file_id
        ]);

        return response()->json([], 204);
    }

    /**
     * Handle request to answer file for a question.
     * 
     */
    public function deleteAnswerFile($question_id, $fileable_id, $file_id)
    {
        $file = app()->call([$this->file_service, 'delete'], [
            'user_id'     => auth()->user()->id,
            'fileable_id' => $fileable_id,
            'file_id'     => $file_id
        ]);

        return response()->json([], 204);
    }
}
