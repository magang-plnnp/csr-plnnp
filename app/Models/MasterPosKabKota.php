<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPosKabkota extends Model
{
    use HasFactory;

    protected $table = 'master_pos_kabkota';
    protected $primaryKey = 'kode_kabupaten';
    public $incrementing = false;
    public $timestamps = false;
}
