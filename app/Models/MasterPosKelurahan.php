<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPosKelurahan extends Model
{
    protected $table = 'master_pos_kelurahan';
    protected $primaryKey = 'kode_desa';
    public $incrementing = false;
    public $timestamps = false;
}