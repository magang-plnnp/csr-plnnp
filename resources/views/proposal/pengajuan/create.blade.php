@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')

@section('content')

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
    @error('kecamatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kelurahan / Desa</label>
    <select id="kelurahan" class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan" required>
        <option value="">-- Pilih Kelurahan / Desa --</option>
    </select>
    <div class="form-text">Lokasi atau tempat desa pengajuan</div>
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
        <input type="number" class="form-control @error('nominal_pengajuan') is-invalid @enderror" name="nominal_pengajuan" value="{{ old('nominal_pengajuan') }}" placeholder="Contoh: Rp. 500.000.00">
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
        <input type="number" class="form-control @error('nominal_disetujui') is-invalid @enderror" name="nominal_disetujui" value="{{ old('nominal_disetujui') }}" placeholder="Contoh: Rp. 500.000.00">
        @error('nominal_disetujui')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Barang Disetujui</label>
        <input type="text" class="form-control @error('barang_disetujui') is-invalid @enderror" name="barang_disetujui" value="{{ old('barang_disetujui') }}" placeholder="Contoh: 26 Papan Peringatan">
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
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil data kecamatan dari endpoint API
    fetch('/kecamatan')
        .then(res => res.json())
        .then(data => {
            const kecamatanSelect = document.getElementById('kecamatan');
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = JSON.stringify({ id: item.id, name: item.name });
                opt.textContent = item.name;
                kecamatanSelect.appendChild(opt);
            });
        });

    // Saat memilih kecamatan
    document.getElementById('kecamatan').addEventListener('change', function () {
        const selected = JSON.parse(this.value);
        const kecamatanId = selected.id;
        const kecamatanName = selected.name;

        // Set hidden input
        document.getElementById('kecamatan_id').value = kecamatanId;
        document.getElementById('kecamatan_nama').value = kecamatanName;

        // Reset dan load kelurahan berdasarkan kecamatan
        const kelurahanSelect = document.getElementById('kelurahan');
        kelurahanSelect.innerHTML = '<option>Loading...</option>';

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
            });
    });

    // Saat memilih kelurahan
    document.getElementById('kelurahan').addEventListener('change', function () {
        if (!this.value) return;
        const selected = JSON.parse(this.value);
        document.getElementById('kelurahan_id').value = selected.id;
        document.getElementById('kelurahan_nama').value = selected.name;
    });
});
</script>


@endpush
@endsection
