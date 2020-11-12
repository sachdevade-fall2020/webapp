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
        $method = strtolower($request->method());
        $route_name = str_replace("/", "_", $request->path());

        Statsd::increment("requests_${method}_${route_name}");

        $timer = Statsd::startTiming("request_execution");
        $response =  $next($request);
        $timer->endTiming("request_execution");

        return $response;
    }

    public function terminate($request, $response)
    {
        Statsd::increment("response_".$response->status());

        Log::info($request->method()." ".$request->path()." ".$response->status());
    }
}
