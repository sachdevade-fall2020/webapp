<?php

namespace App\Services;

use App\Validators\UserValidator;
use App\Repositories\Contracts\UserRepository;

class UserService
{
    protected $users;

    public function __construct(UserRepository $users) 
    {
        $this->users = $users;
    }

    public function create($inputs, UserValidator $validator) 
    {
        $validator->fire($inputs, 'create');

        $inputs['password'] = \Hash::make($inputs['password']);

		$user = $this->users->create([
			'first_name'    => \Arr::get($inputs, 'first_name'),
            'last_name'     => \Arr::get($inputs, 'last_name'),
            'username'      => \Arr::get($inputs, 'username'),
			'password'      => \Arr::get($inputs, 'password'),
        ]);
        
        return $user;
    }

    public function update($id, $inputs, UserValidator $validator) 
    {
        $validator->fire($inputs, 'update', ['user_id' => $id]);

        if (\Arr::has($inputs, 'password')) {
            $inputs['password'] = \Hash::make($inputs['password']);
        }

        $this->users->update($id, \Arr::only($inputs, ['first_name', 'last_name', 'password']));
    }
}
