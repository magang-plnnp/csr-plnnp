<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 30px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
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
            text-align: left;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            text-align: center;
            padding-top: 50px;
        }
    </style>
</head>

<body>

    <h2>BERITA ACARA SERAH TERIMA</h2>
    <h3>BANTUAN PROGRAM KONSERVASI DAS DESA BATUR</h3>
    <p style="text-align: center;">089.BA.KESP/076/UPPTN/2025</p>

    <p>Pada hari ini Rabu tanggal Sembilan bulan Juli tahun Dua Ribu Dua Puluh Lima, yang bertanda tangan dibawah ini:
    </p>

    <div class="section">
        <p><strong>Nama</strong> : Sukarno</p>
        <p><strong>Jabatan</strong> : Manajer Business Support</p>
        <p>Dalam hal ini bertindak sebagai Manajer Business Support PT PLN Nusantara Power UP Paiton, yang selanjutnya
            disebut <strong>PIHAK PERTAMA</strong>.</p>

        <p><strong>Nama</strong> : {{ $data->nama_penerima }}</p>
        <p><strong>Jabatan</strong> : {{ $data->jabatan_penerima }}</p>
        <p>Dalam hal ini bertindak untuk dan atas nama Kelompok PLTMH Tanah Merah, selanjutnya disebut <strong>PIHAK
                KEDUA</strong>.</p>
    </div>

    <p>Dengan ini PIHAK PERTAMA menyerahkan bantuan kepada PIHAK KEDUA berupa:</p>

    <table class="tabel-bantuan">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Bantuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Bibit Alpukat</td>
                <td>500 buah</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Bibit Durian</td>
                <td>500 buah</td>
            </tr>
        </tbody>
    </table>

    <div class="section">
        <p>
            PIHAK PERTAMA menyerahkan bantuan kepada PIHAK KEDUA dengan mengedepankan azas Kepatuhan Terhadap Hukum dan
            Anti Penyuapan antara lain:
        </p>

        <p>(1) PARA PIHAK menyepakati bahwa pada saat melaksanakan program Corporate Social Responsibility ini
            berdasarkan pada prinsip itikad baik, tidak saling mempengaruhi baik langsung maupun tidak langsung guna
            memenuhi keinginannya, menerima serta bertanggungjawab atas segala keputusan yang ditetapkan sesuai dengan
            kesepakatan PARA PIHAK, menghindari serta mencegah terjadinya pertentangan kepentingan (conflict of
            interest), menghindari serta mencegah penyalahgunaan wewenang dan/atau kolusi dan/atau korupsi dengan tujuan
            untuk keuntungan pribadi-golongan-atau pihak lain, dan tidak menerima, tidak menawarkan atau tidak
            menjanjikan untuk memberi atau menerima hadiah, imbalan berupa apa saja kepada siapapun yang diketahui atau
            patut diduga berkaitan dengan pelaksanaan program Corporate Social Responsibility ini (penyuapan).</p>

        <p>(2) PARA PIHAK menyepakati bahwa dalam pelaksanaan program Corporate Social Responsibility ini selalu
            mengambil tindakan yang cukup untuk memastikan PARA PIHAK patuh terhadap setiap hukum Indonesia yang
            berlaku, tidak terbatas pada Undang-Undang Nomor 31 Tahun 1999 Juncto Undang-Undang Nomor 20 Tahun 2001
            tentang Pemberantasan Tindak Pidana Korupsi serta bersedia dikenakan sanksi berdasarkan ketentuan peraturan
            perundang-undangan apabila terbukti terlibat Korupsi, Kolusi, Nepotisme (KKN), penyuapan dan lain
            sebagainya.</p>

        <p>(3) PIHAK KESATU dengan ini menjamin dalam pelaksanaan program Corporate Social Responsibility ini tidak
            menyalahgunakan uang dan/atau dana bantuan selain untuk tujuan sebagaimana diatur dalam Kesepakatan
            Kerjasama ini, tidak di bawah pengaruh kepentingan PIHAK KEDUA atau pihak lainnya dalam mengambil tindakan
            atau keputusan dalam pelaksanaan program Corporate Social Responsibility ini, serta tidak menerima suatu
            kontribusi, pemberian uang, komisi politik, atau hal lainnya yang bernilai dari PIHAK KEDUA atau pihak
            lainnya.</p>

        <p>(4) PIHAK KEDUA selaku penerima bantuan program Corporate Social Responsibility dengan ini menjamin tidak
            akan menawarkan, menjanjikan, memberikan kontribusi, melakukan penyuapan, dan/atau memberikan manfaat lain
            kepada pegawai PIHAK KESATU terkait dengan pelaksanaan program Corporate Social Responsibility ini, serta
            tidak menyalahgunakan dana bantuan program Corporate Social Responsibility tersebut selain untuk tujuan yang
            diatur dalam Kesepakatan Kerja Sama ini.</p>

        <p>(5) Apabila salah satu PIHAK terbukti melanggar ketentuan sebagaimana dimaksud dalam Pasal ini, maka
            Kesepatakan Kerja Sama akan berakhir.</p>
    </div>

    <p>Demikian Berita Acara Serah Terima ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <p>Paiton, 09 Juli 2025</p>

    <table class="ttd">
        <tr>
            <td>PIHAK PERTAMA</td>
            <td>PIHAK KEDUA</td>
        </tr>
        <tr>
            <td height="80px"></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Sukarno</strong></td>
            <td><strong>{{ $data->nama_penerima }}</strong></td>
        </tr>
    </table>

</body>

</html>
