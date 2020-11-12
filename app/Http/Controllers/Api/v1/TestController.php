<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __construct() {
        //
    }

    public function test() {
        return response()->json([
            'message' => 'TESTING: Hello World!'
        ]);
    }
}
