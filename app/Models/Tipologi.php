<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipologi extends Model
{
    protected $table = 'tipologi';

    protected $fillable = ['kode', 'deskripsi', 'created_at', 'updated_at'];

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
