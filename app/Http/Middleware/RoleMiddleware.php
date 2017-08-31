<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\RoleService;
use Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $ne
     * @return mixed
     */
    public function __construct(){
        $this->roleService=new RoleService;
    }

    public function handle($request, Closure $next)
    {
        $valueData = $this->roleService->getPermissionModules();

        if ($valueData != array()) {
            
            Session::put('modulePermission',$valueData);

            return $next($request);
        
        }
        return $next($request);
    }
}
