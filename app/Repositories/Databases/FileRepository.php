<?php

namespace App\Repositories\Databases;

use App\Models\File;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\FileRepository as FileRepositoryContract;

class FileRepository implements FileRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = File::class; 
}