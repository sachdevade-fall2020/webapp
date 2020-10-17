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
            'inputs'      => $inputs
        ]);

        return response()->json($this->getTransformedData($file, new FileTransformer), 201);
    }

    /**
     * Handle request to create file for a question.
     * 
     */
    public function delete($fileable_id, $file_id)
    {
        $file = app()->call([$this->file_service, 'delete'], [
            'user_id'     => auth()->user()->id,
            'file_id'     => $file_id,
            'fileable_id' => $fileable_id
        ]);

        return response()->json([], 204);
    }
}
