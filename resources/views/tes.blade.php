<!DOCTYPE html>
<html>
<head>
    <title>Dropdown Kecamatan & Kelurahan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h3>Lokasi - Kabupaten Probolinggo</h3>

<select id="kecamatan">
    <option value="">-- Pilih Kecamatan --</option>
</select>

<select id="kelurahan">
    <option value="">-- Pilih Kelurahan / Desa --</option>
</select>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/kecamatan')
        .then(res => res.json())
        .then(data => {
            const kecamatanSelect = document.getElementById('kecamatan');
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.name;
                kecamatanSelect.appendChild(opt);
            });
        });

    document.getElementById('kecamatan').addEventListener('change', function () {
        const kecamatanId = this.value;
        const kelurahanSelect = document.getElementById('kelurahan');
        kelurahanSelect.innerHTML = '<option>Loading...</option>';

        fetch(`/kelurahan/${kecamatanId}`)
            .then(res => res.json())
            .then(data => {
                kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    kelurahanSelect.appendChild(opt);
                });
            });
    });
});
</script>

</body>
</html>
