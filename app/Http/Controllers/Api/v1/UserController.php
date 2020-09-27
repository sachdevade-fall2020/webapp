<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $user_service;

    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    public function create() {
        $inputs = request()->only([
            'first_name',
            'last_name',
            'email_address',
            'password'
        ]);

        $user = app()->call([$this->user_service, 'create'], ['inputs' => $inputs]);

        return response()->json([
            'id'              => $user->id,
            'first_name'      => $user->first_name,
            'last_name'       => $user->last_name,
            'email_address'   => $user->email_address,
            'account_created' => $user->account_created,
            'account_updated' => $user->account_updated,
        ], 201);
    }

    public function getSelf() {
        $user = auth()->user();

        return response()->json([
            'id'              => $user->id,
            'first_name'      => $user->first_name,
            'last_name'       => $user->last_name,
            'email_address'   => $user->email_address,
            'account_created' => $user->account_created,
            'account_updated' => $user->account_updated,
        ]);
    }

    public function updateSelf() {
        $inputs = request()->only([
            'first_name',
            'last_name',
            'password'
        ]);

        app()->call([$this->user_service, 'update'], [
            'id' => auth()->user()->id,
            'inputs' => $inputs
        ]);

        return response()->json('', 204);
    }
}
