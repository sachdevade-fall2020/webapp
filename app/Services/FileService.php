<?php

namespace App\Services;

use DB;
use Arr;
use File;
use Statsd;
use Storage;
use Exception;
use Carbon\Carbon;
use App\Validators\FileValidator;
use App\Exceptions\BadRequestException;
use App\Repositories\Contracts\FileRepository;
use App\Repositories\Contracts\AnswerRepository;
use App\Repositories\Contracts\QuestionRepository;

class FileService
{
    protected $files;
    protected $questions;
    protected $answers;

    public function __construct(FileRepository $files, QuestionRepository $questions, AnswerRepository $answers) 
    {
        $this->files = $files;
        $this->questions = $questions;
        $this->answers = $answers;
    }

    public function createQuestionFile($user_id, $question_id, $inputs, FileValidator $validator)
    {
        $validator->fire($inputs, 'create');

        $question = $this->questions->get($question_id);

        throw_if($question->user_id != $user_id, BadRequestException::class, 'Unable to add file');

        return $this->createAndUploadFile(Arr::get($inputs, 'attachment'), $question);
    }

    public function createAnswerFile($user_id, $question_id, $answer_id, $inputs, FileValidator $validator)
    {
        $validator->fire($inputs, 'create');
        
        $question = $this->questions->get($question_id);

        $answer = $this->answers->getWhere('id', $answer_id, ['question_id' => $question->id])->first();

        throw_if($answer->user_id != $user_id, BadRequestException::class, 'Unable to add file');

        return $this->createAndUploadFile(Arr::get($inputs, 'attachment'), $answer);
    }

    private function createAndUploadFile($req_file, $fileable)
    {
        DB::beginTransaction();

        try {
            $file = $this->files->createRelationally($fileable, 'files', [
                'file_name' => $req_file->getClientOriginalName(),
                'md5'       => File::hash($req_file->path()),
                'mime'      => $req_file->getClientMimeType(),
                'size'      => $req_file->getClientSize(),
            ]);

            $this->files->update($file, [
                's3_object_name' => $this->uploadFile($file, $req_file),
                'created_date'   => Carbon::now(),
            ]);

            DB::commit();

            return $file;
        }catch(Exception $e) {
            logger($e->getMessage());

            DB::rollBack();

            throw new BadRequestException("Error uploading file");
        }
    }

    private function generateUploadPath($file)
    {
        return $file->fileable_type."/".$file->fileable_id."/files/".$file->id;
    }

    private function uploadFile($file, $req_file)
    {
        $timer = Statsd::startTiming("s3_execution");
        $object_name = Storage::putFile($this->generateUploadPath($file), $req_file);
        $timer->endTiming("s3_execution");

        return $object_name;
    }

    public function deleteQuestionFile($user_id, $question_id, $file_id)
    {
        $question = $this->questions->get($question_id);

        throw_if($question->user_id != $user_id, BadRequestException::class, 'Unable to delete file');

        $file = $this->files->getWhere('id', $file_id, [
            'fileable_type' => 'questions',
            'fileable_id' => $question->id
        ])->first();

        $this->deleteAndRemoveFile($file);
    }

    public function deleteAnswerFile($user_id, $question_id, $answer_id, $file_id)
    {
        $question = $this->questions->get($question_id);

        $answer = $this->answers->getWhere('id', $answer_id, ['question_id' => $question->id])->first();

        throw_if($answer->user_id != $user_id, BadRequestException::class, 'Unable to delete file');

        $file = $this->files->getWhere('id', $file_id, [
            'fileable_type' => 'answers',
            'fileable_id' => $answer->id
        ])->first();

        $this->deleteAndRemoveFile($file);
    }

    private function deleteAndRemoveFile($file)
    {
        try {
            Storage::deleteDirectory($this->generateUploadPath($file));
            $this->files->delete($file);
        }catch(Exception $e) {
            logger($e->getMessage());
            throw new BadRequestException("Error deleting file");
        }
    }
}
