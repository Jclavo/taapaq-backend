<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionInRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        //Add some routes exception for user
        $listExceptions = array('/users/','/user-details/');
       
        $route = $request->getRequestUri();
        $method = $request->method();
        foreach($listExceptions as $exception){
            if(strpos($route,$exception) !== false){
                switch ($method) {
                    case "PUT":
                        $userID = basename($route); //get the last value from url
                        if($userID == app('auth')->user()->id){
                            return $next($request);
                        }
                        break;
                    default:
                        break;
                }
            break;
            }   
        }

        //Logic to validate permissions
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {

            $permission = $permission . '#' . app('auth')->user()->company_project->project_id;

            $hasPermission = app('auth')->user()::
                join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('role_has_permissions','roles.id','=','role_has_permissions.role_id')
                ->join('permissions','role_has_permissions.permission_id','=','permissions.id')
                ->where('permissions.name','=',$permission)
                ->where('users.id','=',app('auth')->user()->id)
                ->count();

            if ($hasPermission > 0) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
