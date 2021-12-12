<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RfidTemporary;

class UserController extends Controller
{
    public function rfid(Request $request)
    {
        $rfid = $request->rfid;

        if ($rfid) {
            $cek = RfidTemporary::count();
    
            if ($cek > 0) {
                RfidTemporary::truncate();
            }
    
            $list = new RfidTemporary();
            $list->rfid = $request->rfid;
    
            if ($list->save()) {
                return response()->json([
                    'status' => 'Success',
                    'data' => $list
                ]);
            }else{
                return response()->json([
                    'status' => 'Error'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'Error'
            ]);
        }

    }
}
