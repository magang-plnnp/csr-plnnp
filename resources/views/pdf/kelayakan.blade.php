<!DOCTYPE html>
<html lang="id">

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
            font-size: 11px;
        }
        .section p {
            margin: 2px 0;
        }

        /* .label {
            display: inline-block;
            width: 200px; 
            font-weight: bold;
            vertical-align: top;
        }

        .separator {
            display: inline-block;
            width: 10px;
        }

        .value {
            display: inline-block;
        } */
        .label,
        .separator,
        .value {
            display: table-cell;
            vertical-align: top;
        }
        .label {
            width: 200px;
            font-weight: bold;
        }

        .separator {
            width: 10px;
        }

        .value {
            width: auto;
        }
         .data-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
            line-height: 20pt;
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
        border: 1px solid black; /* agar terlihat jelas */
        padding: 10px;
        text-align: center;
        vertical-align: top;
    }
    </style>
</head>

<body>
    <div class="kop-header">
        <table class="kop-table" width="100%">
            <tr>
                <td rowspan="4" class="logo-cell">
                    <img src="{{ public_path('images/logos/logo-pln2.png') }}" style="height: 0.64cm; width: 3.12cm; margin-top: 2px;">
                </td>
                <td class="judul-cell"><strong>PT PLN NUSANTARA POWER</strong></td>
                <td class="info-cell"><strong>Nomor Dokumen</strong> : FMPT-328-12.5.1.a.b.e-001</td>
            </tr>
            <tr>
                <td class="judul-cell">PLN NP INTEGRATED MANAGEMENT SYSTEM</td>
                <td class="info-cell"><strong>Revisi</strong> : 00</td>
            </tr>
            <tr>
                <td rowspan="2" class="judul-cell">
                    FORMULIR ANALISIS PERMINTAAN BANTUAN PROGRAM CSR
                </td>
                <td class="info-cell"><strong>Tanggal Terbit</strong> : {{ \Carbon\Carbon::now()->format('d - m - Y') }}</td>
            </tr>
            <tr>
                {{-- <td class="info-cell"><strong>Halaman</strong> : 1 dari 3</td> --}}
            </tr>
        </table>
    </div>

    <h3>FORMULIR ANALISIS KELAYAKAN PERMINTAAN BANTUAN PROGRAM CSR</h3>
    <h4>PT PLN NP UNIT PEMBANGKITAN PAITON</h4>

    <div class="section">
        <div class="data-row">
            <div class="label">Nama Program</div>
            <div class="separator">:</div>
            <div class="value">{{ $data->proposal->judul }}</div>
        </div>

        <div class="data-row">
            <div class="label">Tipologi</div>
            <div class="separator">:</div>
            <div class="value">{{ optional($data->proposal->tipologi)->deskripsi ?? '-' }}</div>
        </div>

        <div class="data-row">
            <div class="label">Dasar Pelaksanaan Program</div>
            <div class="separator">:</div>
            <div class="value">{{ $data->dasar_pelaksanaan }}</div>
        </div>

        <div class="data-row">
            <div class="label">Latar Belakang Program</div>
            <div class="separator">:</div>
            <div class="value">{{ $data->latar_belakang }}</div>
        </div>

        <div class="data-row">
            <div class="label">Tujuan</div>
            <div class="separator">:</div>
            <div class="value">{{ $data->tujuan }}</div>
        </div>

        <div class="data-row">
            <div class="label">Indikator Lingkungan</div>
            <div class="separator">:</div>
            <div class="value">-</div>
        </div>

        <div class="data-row">
            <div class="label">Indikator Sosial</div>
            <div class="separator">:</div>
            <div class="value">
                Terjalinnya hubungan yang baik antara PT PLN Nusantara Power dengan Stakeholder Bidang Hukum LBH CCI Propinsi Jatim.
            </div>
        </div>

        <div class="data-row">
            <div class="label">Jumlah Penerima Manfaat</div>
            <div class="separator">:</div>
            <div class="value">100 penerima manfaat</div>
        </div>

        <div class="data-row">
            <div class="label">Asal Instansi</div>
            <div class="separator">:</div>
            <div class="value">{{ $data->proposal->instansi_pengajuan }}</div>
        </div>

        <div class="data-row">
            <div class="label">Jenis Stakeholder</div>
            <div class="separator">:</div>
            <div class="value">Lembaga Bantuan Hukum</div>
        </div>

        <div class="data-row">
            <div class="label">Mengetahui (Pejabat Instansi)</div>
            <div class="separator">:</div>
            <div class="value">Hariyanto, CFLE., CLA. (Ketua)</div>
        </div>

        <div class="data-row">
            <div class="label">Bantuan yang diajukan</div>
            <div class="separator">:</div>
            <div class="value">
                Proposal {{ $data->proposal->judul }} senilai Rp {{ number_format($data->proposal->nominal_pengajuan, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="section">
        <p><strong>Analisa Matriks</strong>:</p>
        <table class="table-matriks">
            <thead>
                <tr>
                    <th>Prioritas</th>
                    <th colspan="5">Nilai Dampak</th>
                </tr>
            </thead>
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
            </tbody>
        </table>

        <div class="section">
        <p><strong>Penjelasan Kategori:</strong></p>
        <p>Tidak ada dampak</p>
        <p>Kecil / Sedang / Tinggi / Sangat Tinggi</p>

        <p><strong>Keterangan:</strong></p>
        <table class="kategori-table">
            {{-- <thead>
                <tr>
                    <th style="width: 25%;">Kategori</th>
                    <th style="width: 25%">Keterangan</th>
                </tr>
            </thead> --}}
            <tbody>
                <tr>
                    <td style="background-color: #00b050;">Rendah</td>
                    <td>Nilai bantuan 0% - 25%</td>
                </tr>
                <tr>
                    <td style="background-color: #ffc000;">Sedang</td>
                    <td>Nilai bantuan 0% - 50%</td>
                </tr>
                <tr>
                    <td style="background-color: #e36c09;">Tinggi</td>
                    <td>Nilai bantuan 0% - 75%</td>
                </tr>
                <tr>
                    <td style="background-color: #ff0000;">Ekstreme</td>
                    <td>Nilai bantuan 0% - 100%</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <div class="section">
        <div class="data-row">
            <div class="label">Data Terdahulu</div>
            <div class="separator">:</div>
            <div class="value">Program Baru</div>
        </div>

        <div class="data-row">
            <div class="label">Nilai Bantuan yang disetujui</div>
            <div class="separator">:</div>
            <div class="value">Rp {{ number_format($data->proposal->nominal_pengajuan, 0, ',', '.') }}</div>
        </div>

        <div class="data-row">
            <div class="label">Contact Person</div>
            <div class="separator">:</div>
            <div class="value">Dedy Mistariyanto</div>
        </div>

        <div class="data-row">
            <div class="label">Catatan Khusus</div>
            <div class="separator">:</div>
            <div class="value">-</div>
        </div>
    </div>

    <div class="section">
        <table class="ttd" width="100%">
        <tr>
            <td colspan="5" style="text-align: center;"><strong>Paiton, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong></td>
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

</body>

</html>
