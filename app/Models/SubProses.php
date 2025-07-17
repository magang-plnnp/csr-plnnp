<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProses extends Model
{
    protected $table = 'sub_proses';
    protected $fillable = ['tipe_proses_id', 'nama_sub', 'order_index', 'created_at', 'updated_at'];

    public function tipeProses()
    {
        return $this->belongsTo(TipeProses::class);
    }

    public function checklist()
    {
        return $this->hasMany(ProposalProsesChecklist::class);
    }
}
