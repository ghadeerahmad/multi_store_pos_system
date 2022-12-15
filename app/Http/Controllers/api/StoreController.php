<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = Store::where('user_id', Auth::user()->id)->firstOrFail();
        return success_response($store);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreRequest $request)
    {
        $data = $request->only('name');
        $data['user_id'] = Auth::user()->id;
        $result = DB::transaction(function () use ($request, $data) {
            $store = Store::create($data);
            if ($request->hasFile('logo')) {
                $path = upload($request->file('image'), 'stores/logo');
                $store->logo = $path;
                $store->save();
            }
            return $store;
        });
        if ($result)
            return success_response($result);
        return error_response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, $id)
    {
        $store = Store::where('id', $id)->firstOrFail();
        $data = $request->only('name');
        if ($request->hasFile('logo')) {
            if ($store->logo)
                deleteFile($store->logo);
            $path = upload($request->file('logo'), 'stores/logo');
            $data['logo'] = $path;
        }
        $store->update($data);
        return success_response($store);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Store::where('id', $id)->delete();
        return success_response();
    }
}
