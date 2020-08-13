<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class JobLogDataTableFilterMiddleware
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

        if ($request->input() == null) {
            $url = $request->fullUrlWithQuery(
                [
                    "data_time_between" => Carbon::now()->firstOfMonth()->toDateTimeString()." - ".date("Y-m-d")." 23:59:59",
                    "user_exec" => Auth::id()
                ]
            );

            return redirect($url);
        }

        return $next($request);
    }
}
