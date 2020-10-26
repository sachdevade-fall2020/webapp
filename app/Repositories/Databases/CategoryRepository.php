<?php

namespace App\Repositories\Databases;

use App\Models\Category;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\CategoryRepository as CategoryRepositoryContract;

class CategoryRepository implements CategoryRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = Category::class; 
}