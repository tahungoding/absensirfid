<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function mode($slug)
    {
        $device = Device::where('slug', $slug)->first();

        return response()->json([
            'status' => 'Success',
            'data' => $device
        ]);
    }
}
