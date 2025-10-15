<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelayakan extends Model
{
    use HasFactory;

    protected $table = 'kelayakan';

    protected $fillable = [
        'proposal_id',
        'dasar_pelaksanaan',
        'latar_belakang',
        'tujuan',
        'indikator_lingkungan',
        'indikator_sosial',
        'jumlah_penerima_manfaat',
        'jenis_stakeholder',
        'pejabat_instansi',
        'data_terdahulu',
        'contact_person',
        'catatan_khusus',
        'prioritas',
        'dampak',
        'file_pdf',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
