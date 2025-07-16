<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proposal')->insert([
            [
                'judul' => 'Permohonan Bantuan Dana Selametan Desa Banyuglugur',
                'instansi_pengajuan' => 'Pemdes Banyuglugur',
                'lokasi' => 'Desa Banyuglugur',
                'tanggal_disposisi' => '2025-01-08',
                'nominal_pengajuan' => 104000000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => 10000000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 6, // Alief
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Permohonan Bantuan Haul Masyayikh dan Harlah Ke-76 Ponpes Nurul Jadid',
                'instansi_pengajuan' => 'Ponpes Nurul Jadid',
                'lokasi' => 'Desa Tanjung',
                'tanggal_disposisi' => '2025-01-09',
                'nominal_pengajuan' => 344610000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => 10695000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 5, // Javas
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Partisipasi HUT Ke-3 Media Online Detik Nusantara',
                'instansi_pengajuan' => 'Detik Nusantara',
                'lokasi' => 'Desa Binor',
                'tanggal_disposisi' => '2025-01-08',
                'nominal_pengajuan' => 31000000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => 12000000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 2, // Ibnu
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bantuan Air Bersih Pulau Gili Ketapang',
                'instansi_pengajuan' => 'FPPB',
                'lokasi' => 'Desa Binor',
                'tanggal_disposisi' => '2024-12-05',
                'nominal_pengajuan' => 38250000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 2, // KLBS
                'status' => 'ditolak',
                'nominal_disetujui' => null,
                'barang_disetujui' => null,
                'nama_pic_id' => 2, // Ibnu
                'tipe_proses_id' => null,
                'keterangan' => '-',
                'overdue' => '2025-01-08',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bantuan Tempat Sampah Terpilah',
                'instansi_pengajuan' => 'DLH Probolinggo',
                'lokasi' => 'Kab. Probolinggo',
                'tanggal_disposisi' => null,
                'nominal_pengajuan' => null,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => null,
                'barang_disetujui' => '50 drum',
                'nama_pic_id' => 4, // Dita
                'tipe_proses_id' => 1,
                'keterangan' => '-',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Support Kegiatan Tahun Baru',
                'instansi_pengajuan' => 'Bumdes Binor',
                'lokasi' => 'Desa Binor',
                'tanggal_disposisi' => null,
                'nominal_pengajuan' => null,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => 20000000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 6, // Alief
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Permohonan Bantuan Meja dan Kursi',
                'instansi_pengajuan' => 'SMP Islam Al Hasyimi',
                'lokasi' => 'Desa Besuk',
                'tanggal_disposisi' => '2024-12-06',
                'nominal_pengajuan' => null,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'ditolak',
                'nominal_disetujui' => null,
                'barang_disetujui' => 'bekas kantor',
                'nama_pic_id' => 4, // Dita
                'tipe_proses_id' => null,
                'keterangan' => '-',
                'overdue' => '2025-01-29',
                'progress' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bantuan Peringatan Hari Disabilitas',
                'instansi_pengajuan' => 'PDKP Kab. Prob',
                'lokasi' => 'Kab. Probolinggo',
                'tanggal_disposisi' => '2024-12-30',
                'nominal_pengajuan' => 5000000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'ditolak',
                'nominal_disetujui' => null,
                'barang_disetujui' => '-',
                'nama_pic_id' => 5, // Javas
                'tipe_proses_id' => null,
                'keterangan' => '-',
                'overdue' => '2025-01-08',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bantuan Penghijauan Desa Pondok Kelor',
                'instansi_pengajuan' => 'Karang Taruna Pondok Kelor',
                'lokasi' => 'Desa Pondok Kelor',
                'tanggal_disposisi' => '2024-12-30',
                'nominal_pengajuan' => 21950000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 1, // CRTY
                'status' => 'disetujui',
                'nominal_disetujui' => 3000000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 7, // Nanda
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan UMKM Difabel Pertuni',
                'instansi_pengajuan' => 'Pertuni',
                'lokasi' => 'Kab. Probolinggo',
                'tanggal_disposisi' => '2024-08-14',
                'nominal_pengajuan' => 41084000,
                'barang_pengajuan' => '-',
                'tipologi_id' => 3, // EMPW
                'status' => 'disetujui',
                'nominal_disetujui' => 41084000,
                'barang_disetujui' => '-',
                'nama_pic_id' => 5, // Javas
                'tipe_proses_id' => 1,
                'keterangan' => 'Status 6',
                'overdue' => '2025-01-29',
                'progress' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
