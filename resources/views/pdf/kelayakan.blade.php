<!DOCTYPE html>
<html lang="id">

@php
    function formatTextWithNumbering($text)
    {
        if (empty($text)) {
            return '';
        }

        // Split berdasarkan line breaks
        $lines = preg_split('/\r\n|\r|\n/', $text);
        $output = '';

        foreach ($lines as $line) {
            // Cek apakah baris dimulai dengan penomoran (1. 2. 3. dst)
            if (preg_match('/^(\s*)(\d+)\.\s*(.*)$/', $line, $matches)) {
                $indent = $matches[1];
                $number = $matches[2];
                $content = $matches[3];

                // Buat table layout untuk memastikan nomor dan teks di samping
                $output .= '<div style="display: table; width: 100%; margin: 0; padding: 0;">';
                $output .= '<div style="display: table-row;">';
                $output .= '<div style="display: table-cell; width: 1em; vertical-align: top; padding-right: 0.1em;">' . e($number . '.') . '</div>';
                $output .= '<div style="display: table-cell; vertical-align: top; word-wrap: break-word; word-break: break-word;">' . e($content) . '</div>';
                $output .= '</div>';
                $output .= '</div>';
            } else {
                // Baris biasa tanpa penomoran
                if (trim($line) === '') {
                    $output .= '<br>';
                } else {
                    $output .= e($line) . '<br>';
                }
            }
        }

        return $output;
    }
@endphp

<head>
    <meta charset="UTF-8">
    <title>Formulir Kelayakan</title>
    <style>
        @page {
            /* margin: 130px 30px 60px 30px; sesuaikan margin atas agar tidak tabrakan dengan header */
            margin-top: 72pt;
            margin-bottom: 50pt;
            margin-left: 72pt;
            margin-right: 72pt;
        }

        .kop-header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            text-align: left;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
            line-height: 1.5;
            padding-top: 80px;
        }

        h3 {
            text-align: center;
            margin: 4px 0;
        }

        h4 {
            text-align: center;
            margin: 4px 0;
            padding-bottom: 20px;
        }

        .header,
        .footer {
            text-align: left;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .section {
            margin-top: 10px;
        }

        .section p {
            margin: 2px 0;
        }

        .table-matriks {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        /* Hilangkan border kolom pertama (Prioritas) */
        .table-matriks td:first-child {
            border: none;
        }

        /* Hilangkan border baris terakhir (penjelasan kategori) */
        .table-matriks tr:last-child td {
            border: none;
        }

        .table-matriks th,
        .table-matriks td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
        }

        .ttd td {
            text-align: center;
            padding-top: 40px;
        }

        .kop-surat {
            font-size: 10px;
            margin-bottom: 10px;
        }

        .kop-surat table {
            border-collapse: collapse;
        }

        .kop-surat {
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .kop-surat td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .kop-surat .label {
            font-weight: bold;
        }

        .kop-resmi {
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .kop-resmi td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .kop-table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .kop-table td {
            border: 1px solid black;
            vertical-align: top;
            padding: 4px;
        }

        .kop-table tr {
            height: 30px;
        }

        .logo-cell {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .judul-cell {
            width: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            line-height: 1.3;
        }

        .info-cell {
            width: 35%;
            font-size: 8px;
        }

        .section {
            margin-top: 10px;
            font-size: 12px;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif
        }

        .section p {
            margin: 2px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .data-table td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .data-table .label {
            width: 200px;
            font-weight: bold;
            white-space: nowrap;
        }

        .data-table .separator {
            width: 10px;
            text-align: left;
        }

        .data-table .value {
            word-break: break-word;
            white-space: normal;
        }

        .kategori-table {
            width: auto;
            max-width: 70%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 11px;
        }

        .kategori-table th,
        .kategori-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .ttd {
            margin-top: 40px;
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .ttd td {
            border: 1px solid black;
            /* agar terlihat jelas */
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="kop-header">
        <table class="kop-table" width="100%">
            <tr>
                <td rowspan="4" class="logo-cell">
                    <img src="{{ public_path('images/logos/logo-pln2.png') }}"
                        style="height: 0.64cm; width: 3.12cm; margin-top: 25px;">
                </td>
                <td class="judul-cell"><strong>PT PLN NUSANTARA POWER</strong></td>
                <td class="info-cell"><span style="font-size: 7px"><strong>Nomor Dokumen</strong> :
                        FMPT-328-12.5.1.a.b.e-001</span></td>
            </tr>
            <tr>
                <td class="judul-cell">PLN NP INTEGRATED MANAGEMENT SYSTEM</td>
                <td class="info-cell"><strong>Revisi</strong> : {{ str_pad($data->revisi, 2, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td rowspan="2" class="judul-cell">
                    FORMULIR ANALISIS PERMINTAAN BANTUAN PROGRAM CSR
                </td>
                <td class="info-cell"><strong>Tanggal Terbit</strong> : {{ \Carbon\Carbon::now()->format('d - m - Y') }}
                </td>
            </tr>
            <tr>
                {{-- <td class="info-cell"><strong>Halaman</strong> : 1 dari 3</td> --}}
            </tr>
        </table>
    </div>

    <h3>FORMULIR ANALISIS KELAYAKAN PERMINTAAN BANTUAN PROGRAM CSR</h3>
    <h4>PT PLN NP UNIT PEMBANGKITAN PAITON</h4>

    <div class="section">
        <table class="data-table">
            <tr>
                <td class="label">Nama Program</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->proposal->judul }}</td>
            </tr>
            <tr>
                <td class="label">Tipologi</td>
                <td class="separator">:</td>
                <td class="value">{{ optional($data->proposal->tipologi)->deskripsi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dasar Pelaksanaan Program</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->dasar_pelaksanaan) !!}</td>
            </tr>
            <tr>
                <td class="label">Latar Belakang Program</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->latar_belakang) !!}</td>
            </tr>
            <tr>
                <td class="label">Tujuan</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->tujuan) !!}</td>
            </tr>
            <tr>
                <td class="label">Indikator Lingkungan</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->indikator_lingkungan) !!}</td>
            </tr>
            <tr>
                <td class="label">Indikator Sosial</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->indikator_sosial) !!}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Penerima Manfaat</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->jumlah_penerima_manfaat }} penerima manfaat</td>
            </tr>
            <tr>
                <td class="label">Asal Instansi</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->proposal->instansi_pengajuan }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Stakeholder</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->jenis_stakeholder }}</td>
            </tr>
            <tr>
                <td class="label">Mengetahui (Pejabat Instansi)</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->pejabat_instansi }}</td>
            </tr>
            <tr>
                <td class="label">Bantuan yang diajukan</td>
                <td class="separator">:</td>
                <td class="value">
                    Proposal {{ $data->proposal->judul }} senilai Rp
                    {{ number_format($data->proposal->nominal_pengajuan, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="page-break">
            <p><strong>Analisa Matriks</strong>:</p>
            <table class="table-matriks">
                {{-- <thead>
                    <tr>
                        <th>Prioritas</th>
                        <th colspan="5">Nilai Dampak</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <tr>
                        <td>Prioritas 1</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                        <td style="background-color: #ff0000;">Ekstreme</td>
                        <td style="background-color: #ff0000;">Ekstreme</td>
                    </tr>
                    <tr>
                        <td>Prioritas 2</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                        <td style="background-color: #ff0000;">Ekstreme</td>
                    </tr>
                    <tr>
                        <td>Prioritas 3</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                    </tr>
                    <tr>
                        <td>Prioritas 4</td>
                        <td style="background-color: #00b050;">Rendah</td>
                        <td style="background-color: #00b050;">Rendah</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #e36c09;">Tinggi</td>
                    </tr>
                    <tr>
                        <td>Prioritas 5</td>
                        <td style="background-color: #00b050;">Rendah</td>
                        <td style="background-color: #00b050;">Rendah</td>
                        <td style="background-color: #00b050;">Rendah</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                        <td style="background-color: #ffc000;">Sedang</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width:80px; word-wrap: break-word; white-space: normal;">Tidak ada dampak</td>
                        <td>Kecil</td>
                        <td>Sedang</td>
                        <td>Tinggi</td>
                        <td style="width:80px; word-wrap: break-word; white-space: normal;">Sangat Tinggi</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <p><strong>Keterangan:</strong></p>
            <table class="kategori-table">
                <tbody>
                    <tr>
                        <td style="background-color: #00b050; text-align: center;">Rendah</td>
                        <td>Nilai bantuan 0% - 25%</td>
                    </tr>
                    <tr>
                        <td style="background-color: #ffc000; text-align: center;">Sedang</td>
                        <td>Nilai bantuan 0% - 50%</td>
                    </tr>
                    <tr>
                        <td style="background-color: #e36c09; text-align: center;">Tinggi</td>
                        <td>Nilai bantuan 0% - 75%</td>
                    </tr>
                    <tr>
                        <td style="background-color: #ff0000; text-align: center;">Ekstreme</td>
                        <td>Nilai bantuan 0% - 100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <table class="data-table">
            <tr>
                <td class="label">Data Terdahulu</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->data_terdahulu }}</td>
            </tr>
            <tr>
                <td class="label">Nilai Bantuan yang disetujui</td>
                <td class="separator">:</td>
                <td class="value">Rp {{ number_format($data->proposal->nominal_pengajuan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Contact Person</td>
                <td class="separator">:</td>
                <td class="value">{{ $data->contact_person }}</td>
            </tr>
            <tr>
                <td class="label">Catatan Khusus</td>
                <td class="separator">:</td>
                <td class="value">{!! formatTextWithNumbering($data->catatan_khusus) !!}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="page-break">
            <table class="ttd" width="100%">
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Paiton,
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Mengetahui :</strong></td>
                </tr>

                <!-- Baris Asman SDM -->
                <tr>
                    <td rowspan="3" style="width: 25%; text-align: center; font-weight: bold;">
                        Asman SDM,<br>Umum dan CSR
                    </td>
                    <td colspan="2" style="text-align: center; font-weight: bold; width: 20%;">Diterima</td>
                    <td colspan="2" style="text-align: center; font-weight: bold; width: 55%;">Arahan</td>
                </tr>
                <tr>
                    <td style="width: 10%; text-align: center;">Ya</td>
                    <td style="width: 10%; text-align: center;">Tidak</td>
                    <td colspan="2" rowspan="2" style="width: 55%;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <!-- Baris Manager -->
                <tr>
                    <td rowspan="3" style="width: 25%; text-align: center; font-weight: bold;">
                        Manager Business Support
                    </td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">Diterima</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">Arahan</td>
                </tr>
                <tr>
                    <td style="text-align: center;">Ya</td>
                    <td style="text-align: center;">Tidak</td>
                    <td colspan="2" rowspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>