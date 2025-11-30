<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara';

    protected $fillable = [
        'proposal_id',
        'nomor_surat',
        'nama_penerima',
        'jabatan_penerima',
        'file_pdf',
        'file_upload',
        'bantuan'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
