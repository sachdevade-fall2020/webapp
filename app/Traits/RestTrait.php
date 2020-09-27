<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{
    /**
     * Determines if request is an api call.
     *
     * If the request URI contains 'v1/' for APIs.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return $request->is('v1/*');
    }

    /**
     * Determines if request is an ajax call.
     *
     * @param Request $request
     * @return bool
     */
    protected function isAjaxCall(Request $request)
    {
        return $request->expectsJson();
    }
}
