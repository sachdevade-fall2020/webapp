<?php

namespace App\Transformers;

use App\Models\Category;

class CategoryTransformer extends Transformer
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
    public function transform(Category $category)
    {
        return [
            'category_id' => data_get($category, 'id'),
            'category'    => data_get($category, 'category'),
        ];
    }
}
