<?php

namespace App\Repositories\Databases;

use App\Models\User;
use App\Traits\DatabaseRepositoryTrait;
use App\Repositories\Contracts\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    use DatabaseRepositoryTrait;

    private $model = User::class; 
}