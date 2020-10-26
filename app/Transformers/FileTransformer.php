<?php

namespace App\Transformers;

use App\Models\File;

class FileTransformer extends Transformer
{

    /**
    * constructor
    * @return null
    */
    public function __constructor()
    {
        //
    }

    /**
    * List of resources possible to include
    *
    * @var array
    */
    protected $availableIncludes = [];

    /**
    * List of resources to automatically include
    *
    * @var array
    */
    protected $defaultIncludes = [];

    /**
    * Turn this item object into a generic array
    *
    * @return array
    */
    public function transform(File $file)
    {
        return [
            'file_id'        => data_get($file, 'id'),
            'file_name'      => data_get($file, 'file_name'),
            's3_object_name' => data_get($file, 's3_object_name'),
            'created_date'   => data_get($file, 'created_date'),
        ];
    }
}
