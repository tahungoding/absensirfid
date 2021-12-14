<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recapitulation;
use App\Models\User;

class RecapitulationController extends Controller
{
    public function rfid(Request $request)
    {
        $rfid = $request->rfid;
        $date = date('Y-m-d H:i:s');

        if ($rfid != null && $date != null) {
            $user = User::where('rfid', $rfid)->orderBy('created_at')->first();
            if ($user) {
                if ($user->date_out == null) {
                    $user->date_out = $date;
                    if ($user->save()) {
                        return response()->json([
                            'status' => 'Pulang',
                            'data' => $user
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'Error Pulang'
                        ]); 
                    }
                }else{
                    $new = new Recapitulation();
                    $new->user_id = $user->id;
                    $new->date_in = $date;
                    if ($new->save()) {
                        return response()->json([
                            'status' => 'Datang',
                            'data' => $new
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'Error Datang'
                        ]); 
                    }
                }
            }else{
                return response()->json([
                    'status' => 'Error Kartu'
                ]); 
            }
            
        }else{
            return response()->json([
                'status' => 'Error'
            ]); 
        }

    }
}
