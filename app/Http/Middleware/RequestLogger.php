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
        $method = $request->method();
        $route_name = str_replace(".", "_", $request->route()->getName());

        Statsd::increment("${method}_${route_name}_requests");

        $timer = Statsd::startTiming("request_execution");
        $response =  $next($request);
        $timer->endTiming("request_execution");

        return $response;
    }

    public function terminate($request, $response)
    {
        Statsd::increment($response->status()."_responses");

        Log::info($request->method()." ".$request->path()." ".$response->status());
    }
}
