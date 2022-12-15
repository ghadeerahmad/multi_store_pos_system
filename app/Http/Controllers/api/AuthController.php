<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterStoreAdminRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * register new store admin
     * @param RegisterStoreAdminRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterStoreAdminRequest $request)
    {
        $data = $request->only('first_name', 'last_name', 'phone', 'email');
        $data['password'] = Hash::make($request['password']);
        if (!$request['email'] && !$request['phone'])
            un_proccessable_content_response(trans('auth.phone_or_email_required'));
        $role = Role::storeAdmin()->first();
        if (!$role) return error_response();
        $data['role_id'] = $role->id;
        $data['account_type'] = 'store_admin';
        $reuslt = DB::transaction(function () use ($data, $request) {
            $user = User::create($data);
            if ($request->hasFile('image')) {
                $path = upload($request->file('image'), 'users');
                $user->image = $path;
                $user->save();
            }
            return $user;
        });
        if ($reuslt) {
            $credentials = ['password' => $request['password']];
            if ($request['email']) $credentials['email'] = $request['email'];
            else $credentials['phone'] = $request['phone'];
            $token = JWTAuth::attempt($credentials);
            if ($token) {
                return success_response(['user' => $reuslt, 'token' => $token]);
            }
        }
        return error_response(trans('auth.failed'));
    }
    /**
     * login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'nullable|exists:users,email',
            'phone' => 'nullable|exists:users,phone',
            'password' => 'required'
        ]);
        if (!$request['phone'] && !$request['email'])
            return un_proccessable_content_response(trans('auth.phone_or_email_required'));
        $credentials = ['password' => $request['password']];
        if ($request['phone']) $credentials['phone'] = $request['phone'];
        else $credentials['email'] = $request['email'];
        $token = JWTAuth::attempt($credentials);
        if ($token) {
            $user = User::with('role')->find(Auth::user()->id);
            return success_response(['user' => $user, 'token' => $token]);
        }
        return error_response(trans('auth.failed'));
    }
}
