<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function tanggalTerbilang($date = null)
    {
        $tanggal = $date ? Carbon::parse($date) : Carbon::now();

        $hari = self::ubahHari($tanggal->locale('id')->dayName);
        $tgl = self::terbilang($tanggal->day);
        $bulan = $tanggal->translatedFormat('F');
        $tahun = self::terbilang($tanggal->year);

        return "$hari Tanggal $tgl Bulan $bulan Tahun $tahun";
    }

    public static function ubahHari($hari)
    {
        return match (strtolower($hari)) {
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu',
            default => $hari,
        };
    }

    public static function terbilang($angka)
    {
        $f = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);
        $hasil = $f->format($angka);
        return ucwords($hasil);
    }
}
