<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPosKecamatan extends Model
{
    protected $table = 'master_pos_kecamatan';
    protected $primaryKey = 'kode_kecamatan';
    public $incrementing = false;
    public $timestamps = false;
}
