<?php

namespace App\Http\Controllers;

use App\Models\RfidTemporary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['list'] = User::all();
        return view('pengguna.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = new User();
        $list->name = $request->name;
        $list->email = Str::random(10).'@tahungoding.id';
        $list->rfid = $request->rfid;

        if ($list->save()) {
            return response()->json([
                'status' => 'success',
                'data' => $list
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = User::findOrFail($id);
        if ($list) {
            return response()->json([
                'status' => 'success',
                'data' => $list
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateList(Request $request)
    {
        $list = User::findOrFail($request->id);
        $list->name = $request->name;
        $list->email = Str::random(10).'@tahungoding.id';
        $list->rfid = $request->rfid;

        if ($list->save()) {
            return response()->json([
                'status' => 'success',
                'data' => $list
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
    
    public function deleteList(Request $request)
    {
        $list = User::findOrFail($request->id);

        if ($list->delete()) {
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function rfidTemp()
    {
        $rfid = RfidTemporary::orderBy('created_at', 'desc')->first();

        if ($rfid) {
            return response()->json([
                'status' => 'success',
                'data' => $rfid->rfid ?: 1
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

}
