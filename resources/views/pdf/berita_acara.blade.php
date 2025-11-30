<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara</title>
    <style>
        @page {
            margin-top: 4.5cm;
            margin-bottom: 2cm;
            margin-left: 2.5cm;
            margin-right: 2.54cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.15;
            margin: 30px;
        }

        header {
            position: fixed;
            top: 1.27cm;
            /* jarak dari tepi atas */
            left: 2.5cm;
            right: 2.54cm;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 1.27cm;
            /* jarak dari tepi bawah */
            left: 2.5cm;
            right: 2.54cm;
            text-align: center;
        }

        .section p {
            margin: 4px 0;
        }

        .section p.indent {
            padding-left: 4em;
        }

        .label {
            display: inline-block;
            min-width: 80px;
            /* Sesuaikan agar sejajar */
        }

        .separator {
            display: inline-block;
            width: 10px;
        }

        .value {
            display: inline-block;
        }

        .content {
            margin-top: 0;
            /* biar nggak ada margin dobel */
        }

        .tight-bottom {
            margin-bottom: 0;
            padding-bottom: 0;
            line-height: 1;
            /* pastikan tidak ada space ekstra */
        }

        .tight-top {
            margin-top: 0;
            padding-top: 0;
            line-height: 1;
        }

        .section p.indent {
            margin: 0;
            /* pastikan baris nama/jabatan juga rapat */
            line-height: 1.2;
        }

        .spasi-atas {
            margin-top: 10px;
            /* bisa 8px, 10px, atau sesuai kebutuhan */
        }

        .csr-list {
            padding-left: 1.2em;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .csr-list li {
            text-align: justify;
            margin-bottom: 8px;
        }

        .csr-list-custom {
            counter-reset: item;
            list-style-type: none;
            padding-left: 0;
            margin-left: 1.5em;
        }

        .csr-list-custom li {
            counter-increment: item;
            margin-bottom: 10px;
            text-align: justify;
            position: relative;
            padding-left: 2em;
        }

        .csr-list-custom li::before {
            content: "(" counter(item) ")";
            position: absolute;
            left: 0;
            top: 0;
            font-weight: bold;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
        }

        strong {
            font-weight: bold;
        }

        p {
            text-align: justify;
        }

        .section {
            margin-top: 15px;
        }

        .tabel-bantuan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabel-bantuan th,
        .tabel-bantuan td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .tanggal {
            text-align: center;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
            line-height: 1.2 !important;
        }

        .ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: -5px !important;
        }

        .ttd td {
            text-align: center;
            padding-top: 25px;
        }

        .spasi-ttd td {
            padding-top: 80px;
        }
    </style>
</head>

<body>

    <h2>BERITA ACARA SERAH TERIMA</h2>
    <h3>{{ strtoupper($data->proposal->judul) }}</h3>
    <p style="text-align: center; font-weight: bold;">
        {{ $nomorBeritaAcara }}
    </p>

    <p class="tight-bottom">Pada hari ini {{ \App\Helpers\DateHelper::tanggalTerbilang() }}, yang bertanda tangan dibawah
        ini:
    </p>

    <div class="section tight-top">
        <p class="indent"><span class="label">Nama</span><span class="separator">:</span><span
                class="value">{{ $namaBisnisSupport }}</span></p>
        <p class="indent"><span class="label">Jabatan</span><span class="separator">:</span><span class="value">Manajer
                Business Support</span></p>

        <p>Dalam hal ini bertindak sebagai Manajer Business Support
            <strong>PT PLN Nusantara Power UP Paiton</strong>,
            yang selanjutnya disebut <strong>PIHAK PERTAMA</strong>.
        </p>

        <p class="spasi-atas indent"><span class="label">Nama</span><span class="separator">:</span><span
                class="value">{{ $data->nama_penerima }}</span></p>
        <p class="indent"><span class="label">Jabatan</span><span class="separator">:</span><span
                class="value">{{ $data->jabatan_penerima }}</span></p>

        <p>Dalam hal ini bertindak untuk dan atas nama
            <strong>{{ $proposal->instansi_pengajuan }}</strong>,
            selanjutnya disebut <strong>PIHAK KEDUA</strong>.
        </p>
    </div>

    <p>Dengan ini <strong>PIHAK PERTAMA</strong> menyerahkan bantuan kepada <strong>PIHAK KEDUA</strong> berupa:</p>

    <table class="tabel-bantuan" border="1" cellspacing="0" cellpadding="5"
        style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Jenis Bantuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jenis as $i => $jns)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><i>{{ $jns }}</i></td>
                    <td>{{ $jumlah[$i] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <div class="section">
        <p>
            <strong>PIHAK PERTAMA</strong> menyerahkan bantuan kepada <strong>PIHAK KEDUA</strong> dengan mengedepankan
            azas Kepatuhan Terhadap Hukum dan
            Anti Penyuapan antara lain:
        </p>
        <ol class="csr-list-custom">
            <li><strong>PARA PIHAK</strong> menyepakati bahwa pada saat melaksanakan program Corporate Social
                Responsibility ini
                berdasarkan pada prinsip itikad baik, tidak saling mempengaruhi baik langsung maupun tidak langsung guna
                memenuhi keinginannya, menerima serta bertanggungjawab atas segala keputusan yang ditetapkan sesuai
                dengan
                kesepakatan <strong>PARA PIHAK</strong>, menghindari serta mencegah terjadinya pertentangan kepentingan
                (conflict of
                interest), menghindari serta mencegah penyalahgunaan wewenang dan/atau kolusi dan/atau korupsi dengan
                tujuan
                untuk keuntungan pribadi-golongan-atau pihak lain, dan tidak menerima, tidak menawarkan atau tidak
                menjanjikan untuk memberi atau menerima hadiah, imbalan berupa apa saja kepada siapapun yang diketahui
                atau
                patut diduga berkaitan dengan pelaksanaan program Corporate Social Responsibility ini (penyuapan).
            </li>
            <li><strong>PARA PIHAK</strong> menyepakati bahwa dalam pelaksanaan program Corporate Social Responsibility
                ini selalu
                mengambil tindakan yang cukup untuk memastikan <strong>PARA PIHAK</strong> patuh terhadap setiap hukum
                Indonesia yang
                berlaku, tidak terbatas pada Undang-Undang Nomor 31 Tahun 1999 Juncto Undang-Undang Nomor 20 Tahun 2001
                tentang Pemberantasan Tindak Pidana Korupsi serta bersedia dikenakan sanksi berdasarkan ketentuan
                peraturan
                perundang-undangan apabila terbukti terlibat Korupsi, Kolusi, Nepotisme (KKN), penyuapan dan lain
                sebagainya.
            </li>
            <li><strong>PIHAK KESATU</strong> dengan ini menjamin dalam pelaksanaan program Corporate Social
                Responsibility ini tidak
                menyalahgunakan uang dan/atau dana bantuan selain untuk tujuan sebagaimana diatur dalam Kesepakatan
                Kerjasama ini, tidak di bawah pengaruh kepentingan <strong>PIHAK KEDUA</strong> atau <strong>pihak
                    lainnya</strong> dalam mengambil tindakan
                atau keputusan, serta tidak menerima kontribusi, pemberian uang, komisi politik, atau hal lainnya yang
                bernilai dari <strong>PIHAK KEDUA</strong> atau <strong>pihak lainnya</strong>.
            </li>
            <li><strong>PIHAK KEDUA</strong> selaku penerima bantuan program Corporate Social Responsibility menjamin
                tidak akan
                menawarkan, menjanjikan, memberikan kontribusi, melakukan penyuapan, dan/atau memberikan manfaat lain
                kepada
                pegawai <strong>PIHAK KESATU</strong>, serta tidak menyalahgunakan dana bantuan program Corporate Social
                Responsibility
                tersebut selain untuk tujuan dalam Kesepakatan Kerja Sama ini.
            </li>
            <li>Apabila salah satu <strong>PIHAK</strong> terbukti melanggar ketentuan sebagaimana dimaksud dalam Pasal
                ini, maka
                Kesepakatan Kerja Sama akan berakhir.
            </li>
        </ol>
    </div>

    <p>Demikian Berita Acara Serah Terima ini dibuat untuk dipergunakan sebagaimana mestinya.
        <br><br>
    </p>

    <p class="tanggal">Paiton, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table class="ttd">
        <tr>
            <td><strong>PIHAK PERTAMA</strong></td>
            <td><strong>PIHAK KEDUA</strong></td>
        </tr>
        <tr class="spasi-ttd">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>{{ $namaBisnisSupport }}</strong></td>
            <td><strong>{{ $data->nama_penerima }}</strong></td>
        </tr>
    </table>

</body>

</html>
