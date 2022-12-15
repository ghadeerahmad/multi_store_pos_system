<?php

namespace App\Http\Middleware;

use App\Models\StoreRole as ModelsStoreRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $storeRole = ModelsStoreRole::with('permissions')
            ->where('id', Auth::user()->store_role_id)->first();
        if ($storeRole) {
            $permissions = $storeRole->permissions;
            foreach ($permissions as $item) {
                if ($item->guard_name == $permission)
                    return $next($request);
            }
        }
        return forbidden_response();
    }
}
