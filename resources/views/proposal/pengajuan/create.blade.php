@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Select2 Bootstrap 4 Theme --}}
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@endpush
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Input Data Proposal</h5>
                    <div class="card">
                        <div class="card-body">
    <form action="{{ route('proposal.store') }}" method="POST">
    @csrf
    <input type="hidden" name="kecamatan_id" id="kecamatan_id">
<input type="hidden" name="kecamatan_nama" id="kecamatan_nama">
<input type="hidden" name="kelurahan_id" id="kelurahan_id">
<input type="hidden" name="kelurahan_nama" id="kelurahan_nama">


    <div class="mb-3">
        <label class="form-label">Judul Pengajuan</label>
        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Pengajuan Bantuan Dana Desa">
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Instansi Pengajuan</label>
        <input type="text" class="form-control @error('instansi_pengajuan') is-invalid @enderror" name="instansi_pengajuan" value="{{ old('instansi_pengajuan') }}" required placeholder="Contoh: Dinas Sosial Kabupaten Malang">

        @error('instansi_pengajuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

<div class="mb-3">
    <label class="form-label">Kecamatan</label>
    <select id="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan" required>
        <option value="">-- Pilih Kecamatan --</option>
    </select>
     <div class="form-text">Pilih kecamatan sesuai dengan wilayah pengajuan yang berada di Kabupaten Probolinggo.</div>
    @error('kecamatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kelurahan / Desa</label>
    <select id="kelurahan" class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan" required>
        <option value="">-- Pilih Kelurahan / Desa --</option>
    </select>
    <div class="form-text">Pilih kelurahan atau desa yang berada di dalam kecamatan yang telah dipilih.</div>
    @error('kelurahan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


    <div class="mb-3">
        <label class="form-label">Tanggal Disposisi</label>
        <input type="date" class="form-control @error('tanggal_disposisi') is-invalid @enderror" name="tanggal_disposisi" value="{{ old('tanggal_disposisi') }}" required>
        @error('tanggal_disposisi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
    <label class="form-label">Nominal Pengajuan</label>
    <input type="text" id="nominal_pengajuan" class="form-control @error('nominal_pengajuan') is-invalid @enderror"
           name="nominal_pengajuan" value="{{ old('nominal_pengajuan') }}"
           placeholder="Contoh: Rp500.000">
    <div class="form-text">Bisa dikosongi jika tidak ada nominal uang</div>
    @error('nominal_pengajuan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


    <div class="mb-3">
        <label class="form-label">Barang Pengajuan</label>
        <input type="text" class="form-control @error('barang_pengajuan') is-invalid @enderror" name="barang_pengajuan" value="{{ old('barang_pengajuan') }}" placeholder="Contoh: 26 Papan Peringatan">
        <div class="form-text">Bisa dikosongi jika tidak ada barang pengajuan</div>
        @error('barang_pengajuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Tipologi</label>
        <select name="tipologi_id" class="form-control @error('tipologi_id') is-invalid @enderror" required>
            <option value="">-- Pilih Tipologi --</option>
            @foreach ($tipologi as $item)
                <option value="{{ $item->id }}" {{ old('tipologi_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->kode }} - {{ $item->deskripsi }}
                </option>
            @endforeach
        </select>
        @error('tipologi_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Setuju / Tidak setuju</label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
            <option value="">-- Pilih Status Persetujuan --</option>
            <option value="disetuju" {{ old('status') == 'disetuju' ? 'selected' : '' }}>Setuju</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Tolak</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
    <label class="form-label">Nominal Disetujui</label>
    <input type="text" id="nominal_disetujui" class="form-control @error('nominal_disetujui') is-invalid @enderror"
           name="nominal_disetujui" value="{{ old('nominal_disetujui') }}"
           placeholder="Contoh: Rp500.000">
    <div class="form-text">Isi hanya jika pengajuan disetujui atau masih dalam status pending. Kosongkan jika tidak ada nominal yang disetujui.</div>
    @error('nominal_disetujui')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Barang Disetujui</label>
    <input type="text" class="form-control @error('barang_disetujui') is-invalid @enderror"
           name="barang_disetujui" value="{{ old('barang_disetujui') }}"
           placeholder="Contoh: 26 Papan Peringatan">
    <div class="form-text">Isi hanya jika pengajuan disetujui atau masih dalam status pending. Kosongkan jika tidak ada barang yang disetujui.</div>
    @error('barang_disetujui')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


   
    <div class="mb-3">
        <label class="form-label">PIC</label>
        <input
            type="text"
            class="form-control @error('nama_pic_id') is-invalid @enderror"
            name="nama_pic_id_display"
            value="{{ Auth::user()->nama }}"
            disabled>
        <input
            type="hidden"
            name="nama_pic_id"
            value="{{ Auth::user()->id }}">
        <div class="form-text">Nama PIC diatur secara otomatis sesuai dengan pengguna yang sedang login.</div>
        @error('nama_pic_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label class="form-label">Proses</label>
        <select name="tipe_proses_id" class="form-control @error('tipe_proses_id') is-invalid @enderror" required>
            <option value="">-- Pilih Proses --</option>
            @foreach ($proses as $item)
                <option value="{{ $item->id }}" {{ old('tipe_proses_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama ?? $item->name }}
                </option>
            @endforeach
        </select>
        @error('tipe_proses_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}"  placeholder="Contoh: Disetujui sebagian karena keterbatasan anggaran">
        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Overdue</label>
        <input type="date" class="form-control @error('overdue') is-invalid @enderror" name="overdue" value="{{ old('overdue') }}">
        @error('overdue')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" style="background-color: #78C841; color: white;" class="btn">Submit</button>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');

            // Ambil data kecamatan
            fetch('/kecamatan')
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = JSON.stringify({ id: item.id, name: item.name });
                        opt.textContent = item.name;
                        kecamatanSelect.appendChild(opt);
                    });

                    // Inisialisasi Select2 untuk kecamatan
                    $('#kecamatan').select2({
                        placeholder: "-- Pilih Kecamatan --",
                        theme: 'bootstrap4',
                        allowClear: true
                    });
                });

            // Saat memilih kecamatan
            $('#kecamatan').on('change', function () {
                const selectedValue = $(this).val();
                if (!selectedValue) return;

                const selected = JSON.parse(selectedValue);
                const kecamatanId = selected.id;
                const kecamatanName = selected.name;

                document.getElementById('kecamatan_id').value = kecamatanId;
                document.getElementById('kecamatan_nama').value = kecamatanName;

                // Kosongkan dan destroy select2 sebelumnya di kelurahan
                $('#kelurahan').val(null).trigger('change');
                if ($.fn.select2 && $('#kelurahan').data('select2')) {
                    $('#kelurahan').select2('destroy');
                }

                kelurahanSelect.innerHTML = '<option value="">Loading...</option>';

                fetch(`/kelurahan/${kecamatanId}`)
                    .then(res => res.json())
                    .then(data => {
                        kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = JSON.stringify({ id: item.id, name: item.name });
                            opt.textContent = item.name;
                            kelurahanSelect.appendChild(opt);
                        });

                        // Re-inisialisasi Select2 untuk kelurahan
                        $('#kelurahan').select2({
                            placeholder: "-- Pilih Kelurahan / Desa --",
                            theme: 'bootstrap4',
                            allowClear: true
                        });
                    });
            });

            // Saat memilih kelurahan
            $('#kelurahan').on('change', function () {
                const selectedValue = $(this).val();
                if (!selectedValue) return;

                const selected = JSON.parse(selectedValue);
                document.getElementById('kelurahan_id').value = selected.id;
                document.getElementById('kelurahan_nama').value = selected.name;
            });
        });
    </script>

<script>
    function formatRupiah(angka, prefix = 'Rp') {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix + ' ' + rupiah;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputPengajuan = document.getElementById('nominal_pengajuan');
        const inputDisetujui = document.getElementById('nominal_disetujui');

        [inputPengajuan, inputDisetujui].forEach(input => {
            if (!input) return;

            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = value ? formatRupiah(value) : '';
            });

            if (input.value) {
                input.value = formatRupiah(input.value.replace(/[^0-9]/g, ''));
            }
        });
    });
</script>

@endpush
@endsection
