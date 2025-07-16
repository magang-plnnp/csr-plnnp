<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'judul', 'instansi_pengajuan', 'lokasi', 'tanggal_disposisi', 'nominal_pengajuan',
        'barang_pengajuan', 'tipologi_id', 'status', 'nominal_disetujui', 'barang_disetujui',
        'nama_pic_id', 'tipe_proses_id', 'keterangan', 'overdue', 'progress',
        'created_at', 'updated_at',
    ];

    public function tipologi()
    {
        return $this->belongsTo(Tipologi::class);
    }

    public function namaPic()
    {
        return $this->belongsTo(User::class, 'nama_pic_id');
    }

    public function tipeProses()
    {
        return $this->belongsTo(TipeProses::class);
    }

    public function checklist()
    {
        return $this->hasMany(ProposalProsesChecklist::class);
    }
}
