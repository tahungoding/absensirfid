<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidTemporary extends Model
{
    use HasFactory;

    protected $table = 'rfid_temporaries';
    protected $fillable = ['rfid'];
}
