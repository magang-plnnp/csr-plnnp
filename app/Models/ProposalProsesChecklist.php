<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalProsesChecklist extends Model
{
    protected $table = 'proposal_proses_checklist';

    protected $fillable = [
        'proposal_id', 'sub_proses_id', 'is_checked', 'checked_at', 'updated_at'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function subProses()
    {
        return $this->belongsTo(SubProses::class);
    }
}
