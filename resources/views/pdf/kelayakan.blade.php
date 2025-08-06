<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Formulir Kelayakan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 30px;
            line-height: 1.5;
        }

        h3,
        h4 {
            text-align: center;
            margin: 4px 0;
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
    </style>
</head>

<body>

    <h3>FORMULIR ANALISIS KELAYAKAN PERMINTAAN BANTUAN PROGRAM CSR</h3>
    <h4>PT PLN NP UNIT PEMBANGKITAN PAITON</h4>

    <div class="section">
        <p><strong>Nama Program</strong> : Bantuan Acara Rapat Kerja Wilayah LBH CCI Propinsi Jatim</p>
        <p><strong>Tipologi</strong> : Charity</p>
        <p><strong>Dasar Pelaksanaan Program</strong> : {{ $data->dasar_pelaksanaan }}</p>
        <p><strong>Latar Belakang Program</strong> : {{ $data->latar_belakang }}</p>
        <p><strong>Tujuan</strong> : {{ $data->tujuan }}</p>
        <p><strong>Indikator Lingkungan</strong> : -</p>
        <p><strong>Indikator Sosial</strong> : Terjalinnya hubungan yang baik antara Perusahaan PT PLN Nusantara Power
            dengan Stakeholder Bidang Hukum LBH CCI Propinsi Jatim.</p>
        <p><strong>Jumlah Penerima Manfaat</strong> : 100 penerima manfaat</p>
        <p><strong>Asal Instansi</strong> : LBH CCI Propinsi Jawa Timur</p>
        <p><strong>Jenis Stakeholder</strong> : Lembaga Bantuan Hukum</p>
        <p><strong>Mengetahui (Pejabat Instansi)</strong> : Hariyanto, CFLE., CLA. (Ketua)</p>
        <p><strong>Bantuan yang diajukan</strong> : Proposal Partisipasi Kegiatan HUT senilai Rp34.700.000</p>
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
                    <td>Sedang</td>
                    <td>Tinggi</td>
                    <td>Tinggi</td>
                    <td>Ekstreme</td>
                    <td>Ekstreme</td>
                </tr>
                <tr>
                    <td>Prioritas 2</td>
                    <td>Sedang</td>
                    <td>Sedang</td>
                    <td>Tinggi</td>
                    <td>Tinggi</td>
                    <td>Ekstreme</td>
                </tr>
                <tr>
                    <td>Prioritas 3</td>
                    <td>Sedang</td>
                    <td>Sedang</td>
                    <td>Sedang</td>
                    <td>Tinggi</td>
                    <td>Tinggi</td>
                </tr>
                <tr>
                    <td>Prioritas 4</td>
                    <td>Rendah</td>
                    <td>Rendah</td>
                    <td>Sedang</td>
                    <td>Sedang</td>
                    <td>Tinggi</td>
                </tr>
                <tr>
                    <td>Prioritas 5</td>
                    <td>Rendah</td>
                    <td>Rendah</td>
                    <td>Rendah</td>
                    <td>Sedang</td>
                    <td>Sedang</td>
                </tr>
            </tbody>
        </table>

        <p class="section">
            <strong>Penjelasan Kategori:</strong><br>
            Tidak ada dampak<br>
            Kecil / Sedang / Tinggi / Sangat Tinggi<br><br>
            <strong>Keterangan:</strong><br>
            Rendah : Nilai bantuan 0% - 25%<br>
            Sedang : Nilai bantuan 0% - 50%<br>
            Tinggi : Nilai bantuan 0% - 75%<br>
            Ekstreme : Nilai bantuan 0% - 100%
        </p>
    </div>

    <div class="section">
        <p><strong>Data Terdahulu</strong> : Program Baru</p>
        <p><strong>Nilai Bantuan yang disetujui</strong> : Rp2.000.000</p>
        <p><strong>Contact Person</strong> : Dedy Mistariyanto</p>
        <p><strong>Catatan Khusus</strong> : -</p>
    </div>

    <div class="section">
        <p>Paiton, 10 Juni 2025</p>
        <p><strong>Mengetahui :</strong></p>
        <table class="ttd" width="100%">
            <tr>
                <td>Asman SDM, Umum dan CSR</td>
                <td>Manager Business Support</td>
            </tr>
            <tr>
                <td height="60px">Diterima: Ya / Tidak</td>
                <td>Diterima: Ya / Tidak</td>
            </tr>
        </table>
    </div>

</body>

</html>
