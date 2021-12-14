<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recapitulation;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use App\Models\Device;

class RecapitulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['list'] = Recapitulation::all();
        $data['pengguna'] = User::all();

        $mode = Device::where('slug', 'absensi-rfid')->first();
        $mode->mode = 'absensi';
        $mode->save();

        return view('rekapitulasi.index', $data);
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
        $list = new Recapitulation();
        $list->user_id = $request->user_id;
        $list->date_in = $request->date_in;
        $list->date_out = $request->date_out;

        if ($list->save()) {
            $list = Recapitulation::findOrFail($list->id);
            $list->name = $list->pengguna->name;    
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
        $list = Recapitulation::findOrFail($id);
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
        $list = Recapitulation::findOrFail($request->id);
        $list->user_id = $request->user_id;
        $list->date_in = $request->date_in;
        $list->date_out = $request->date_out;

        if ($list->save()) {
            $list = Recapitulation::findOrFail($list->id);
            $list->name = $list->pengguna->name;    
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
        $list = Recapitulation::findOrFail($request->id);

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

    public function table()
    {
        $list = Recapitulation::orderBy('created_at', 'desc')->get();
        $table = "";
        $no = 1;

        foreach ($list as $key => $v) {
            $table .= '<tr id="list_'.$v->id.'">';
            $table .= '<th>'.$no++.'</th>';
            $table .= '<td>'.$v->pengguna->name.'</td>';
            $table .= '<td>'.$v->date_in.'</td>';
            $table .= '<td>'.$v->date_out.'</td>';
            $table .= '<td>';
            $table .= '<a href="javascript:void(0)" data-id="'.$v->id.'"
                        onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"><span
                            class="fa fa-edit"></span></a>
                    <a href="javascript:void(0)" onclick="listDelete('.$v->id.')"
                        class="btn btn-outline-danger btn-sm"><span class="fa fa-trash"></span></a>
                </td>
            </tr>';
        }

        return $table;
        
    }
}
