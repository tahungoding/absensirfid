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
        $date = $request->date;

        if ($rfid != null && $date != null) {
            $cek = Recapitulation::where('rfid', $rfid)->orderBy('created_at')->first();
    
            if ($cek) {
                if ($cek->date_out == null) {
                    $cek->date_out = $date;
                }else{
                    $cek = new Recapitulation();
                    $cek->rfid = $rfid;
                    $cek->date_in = $date;
                }
                return $cek->save();
            }else{
                $cek = new Recapitulation();
                $cek->rfid = $rfid;
                $cek->date_in = $date;

                return $cek->save();
            }
            
        }else{
            return 'Error';
        }

    }
}
