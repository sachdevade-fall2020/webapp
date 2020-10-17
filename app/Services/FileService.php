<?php

namespace App\Services;

use DB;
use Arr;
use File;
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

    public function create($user_id, $fileable_id, $type, $inputs, FileValidator $validator) 
    {
        $validator->fire($inputs, 'create');

        $fileable = $this->getUserFileableForFile($fileable_id, $type, $user_id);

        $req_file = Arr::get($inputs, 'attachment');

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

    private function getUserFileableForFile($fileable_id, $type, $user_id)
    {
        switch ($type) {
            case 'question':
                return $this->questions->getWhere('id', $fileable_id, ['user_id' => $user_id])->first();
            
            case 'answer':
                return $this->answers->getWhere('id', $fileable_id, ['user_id' => $user_id])->first();
            
            default:
                throw new BadRequestException('Invalid File Type');    
        }
        
    }

    private function generateUploadPath($file)
    {
        return $file->fileable_type."/".$file->fileable_id."/files/".$file->id;
    }

    private function uploadFile($file, $req_file)
    {
        return Storage::putFile($this->generateUploadPath($file), $req_file);
    }

    public function get($file_id, $fileable_id)
    {
        return $this->files->getWhere('id', $file_id, ['fileable_id' => $fileable_id])->first();
    }

    public function delete($user_id, $file_id, $fileable_id) 
    {
        $file = $this->get($file_id, $fileable_id, $user_id);

        throw_if($file->fileable->user_id != $user_id, BadRequestException::class, 'Unable to delete file');

        try {
            Storage::deleteDirectory($this->generateUploadPath($file));
            $this->files->delete($file);
        }catch(Exception $e) {
            logger($e->getMessage());
            throw new BadRequestException("Error deleting file");
        }
    }
}
