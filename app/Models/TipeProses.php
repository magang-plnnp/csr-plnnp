<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeProses extends Model
{
    protected $fillable = ['nama', 'created_at', 'updated_at'];

    public function subProses()
    {
        return $this->hasMany(SubProses::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
