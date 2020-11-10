<?php

namespace App\Http\Middleware;

use Log;
use Statsd;
use Closure;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Statsd::increment('requests');

        $timer = Statsd::startTiming("request_execution");
        $response =  $next($request);
        $timer->endTiming("request_execution");

        return $response;
    }

    public function terminate($request, $response)
    {
        Log::info($request->method()." ".$request->path()." ".$response->status());
    }
}
