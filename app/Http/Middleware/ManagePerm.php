<?php 

namespace App\Http\Middleware;
use Auth;

use Closure;

class managePerm {

/**
* Handle an incoming request.
*
* @param \Illuminate\Http\Request $request
* @param \Closure $next
* @return mixed
*/
public function handle($request, Closure $next)
{	
if(Auth::user()->type == 'admin') {
return abort(401,'Not authorized'); //Or redirect() or whatever you want
}
return $next($request);
}

}