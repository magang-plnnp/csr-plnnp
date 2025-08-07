@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')

@section('content')
    @push('styles')
        {{-- Select2 CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- Select2 Bootstrap 4 Theme --}}
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
            rel="stylesheet" />
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
                                <input type="hidden" id="kabupaten_id" name="kabupaten_id">
                                <input type="hidden" id="kabupaten_nama" name="kabupaten_nama">
                                <input type="hidden" id="kecamatan_id" name="kecamatan_id">
                                <input type="hidden" id="kecamatan_nama" name="kecamatan_nama">
                                <input type="hidden" id="kelurahan_id" name="kelurahan_id">
                                <input type="hidden" id="kelurahan_nama" name="kelurahan_nama">


                                <div class="mb-3">
                                    <label class="form-label">Judul Pengajuan</label>
                                    <input type="text" id="judul"
                                        class="form-control @error('judul') is-invalid @enderror" name="judul"
                                        value="{{ old('judul') }}" required
                                        placeholder="Contoh: Pengajuan Bantuan Dana Desa">
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Instansi Pengajuan</label>
                                    <input type="text"
                                        class="form-control @error('instansi_pengajuan') is-invalid @enderror"
                                        name="instansi_pengajuan" value="{{ old('instansi_pengajuan') }}" required
                                        placeholder="Contoh: Dinas Sosial Kabupaten Malang">

                                    @error('instansi_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kabupaten / Kota</label>
                                        <select id="kabupaten" name="kabupaten_id"
                                            class="form-select @error('kabupaten_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kabupaten / Kota --</option>
                                        </select>
                                        <div class="form-text">Pilih Kabupaten atau Kota sesuai wilayah pengajuan.</div>
                                        @error('kabupaten_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan_id"
                                            class="form-select @error('kecamatan_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                        <div class="form-text">Pilih kecamatan sesuai dengan wilayah pengajuan yang berada
                                            di Kabupaten Probolinggo.</div>
                                        @error('kecamatan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kelurahan / Desa</label>
                                        <select id="kelurahan" name="kelurahan_id"
                                            class="form-select @error('kelurahan_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kelurahan / Desa --</option>
                                        </select>
                                        <div class="form-text">Pilih kelurahan atau desa yang berada di dalam kecamatan yang
                                            telah dipilih.</div>
                                        @error('kelurahan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Disposisi</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_disposisi') is-invalid @enderror"
                                        name="tanggal_disposisi" value="{{ old('tanggal_disposisi') }}" required>
                                    @error('tanggal_disposisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nominal Pengajuan</label>
                                        <input type="text" id="nominal_pengajuan"
                                            class="form-control @error('nominal_pengajuan') is-invalid @enderror"
                                            name="nominal_pengajuan" value="{{ old('nominal_pengajuan') }}"
                                            placeholder="Contoh: Rp500.000">
                                        <div class="form-text">Bisa dikosongi jika tidak ada nominal uang</div>
                                        @error('nominal_pengajuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Barang Pengajuan</label>
                                        <input type="text"
                                            class="form-control @error('barang_pengajuan') is-invalid @enderror"
                                            name="barang_pengajuan" value="{{ old('barang_pengajuan') }}"
                                            placeholder="Contoh: 26 Papan Peringatan">
                                        <div class="form-text">Bisa dikosongi jika tidak ada barang pengajuan</div>
                                        @error('barang_pengajuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipologi</label>
                                        <select name="tipologi_id"
                                            class="form-control @error('tipologi_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Tipologi --</option>
                                            @foreach ($tipologi as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('tipologi_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->kode }} - {{ $item->deskripsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tipologi_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Setuju / Tidak setuju</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status"
                                            required>
                                            <option value="">-- Pilih Status Persetujuan --</option>
                                            <option value="disetujui"
                                                {{ old('status') == 'disetujui' ? 'selected' : '' }}>
                                                Setuju</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>
                                                Tolak</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nominal Disetujui</label>
                                        <input type="text" id="nominal_disetujui"
                                            class="form-control @error('nominal_disetujui') is-invalid @enderror"
                                            name="nominal_disetujui" value="{{ old('nominal_disetujui') }}"
                                            placeholder="Contoh: Rp500.000" required>
                                        <div class="form-text">Isi hanya jika pengajuan disetujui atau masih dalam status
                                            pending. Kosongkan jika tidak ada nominal yang disetujui.</div>
                                        @error('nominal_disetujui')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Barang Disetujui</label>
                                        <input type="text"
                                            class="form-control @error('barang_disetujui') is-invalid @enderror"
                                            name="barang_disetujui" value="{{ old('barang_disetujui') }}"
                                            placeholder="Contoh: 26 Papan Peringatan">
                                        <div class="form-text">Isi hanya jika pengajuan disetujui atau masih dalam status
                                            pending. Kosongkan jika tidak ada barang yang disetujui.</div>
                                        @error('barang_disetujui')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="mb-3">
                                    <label class="form-label">PIC</label>
                                    <input type="text" class="form-control @error('nama_pic_id') is-invalid @enderror"
                                        name="nama_pic_id_display" value="{{ Auth::user()->nama }}" disabled>
                                    <input type="hidden" name="nama_pic_id" value="{{ Auth::user()->id }}">
                                    <div class="form-text">Nama PIC diatur secara otomatis sesuai dengan pengguna yang
                                        sedang login.</div>
                                    @error('nama_pic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Proses</label>
                                    <select name="tipe_proses_id"
                                        class="form-control @error('tipe_proses_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Proses --</option>
                                        @foreach ($proses as $item)
                                            @php
                                                $subList = $item->subProses->pluck('nama_sub')->implode(' - ');
                                                $label = $item->nama . ($subList ? " ($subList)" : '');
                                            @endphp
                                            <option value="{{ $item->id }}"
                                                {{ old('tipe_proses_id') == $item->id ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipe_proses_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                        name="keterangan" value="{{ old('keterangan') }}"
                                        placeholder="Contoh: Disetujui sebagian karena keterbatasan anggaran">
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Overdue</label>
                                    <input type="date" class="form-control @error('overdue') is-invalid @enderror"
                                        name="overdue" value="{{ old('overdue') }}">
                                    @error('overdue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" style="background-color: #78C841; color: white;"
                                    class="btn">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Select2 JS --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi dropdown
                const kabupatenSelect = document.getElementById('kabupaten');
                const kecamatanSelect = document.getElementById('kecamatan');
                const kelurahanSelect = document.getElementById('kelurahan');

                const kabupatenIdInput = document.getElementById('kabupaten_id');
                const kabupatenNamaInput = document.getElementById('kabupaten_nama');
                const kecamatanIdInput = document.getElementById('kecamatan_id');
                const kecamatanNamaInput = document.getElementById('kecamatan_nama');
                const kelurahanIdInput = document.getElementById('kelurahan_id');
                const kelurahanNamaInput = document.getElementById('kelurahan_nama');

                fetch('/kabupaten')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            const option = new Option(item.name, item.id);
                            option.setAttribute('data-name', item.name);
                            kabupatenSelect.add(option);
                        });
                    });

                kabupatenSelect.addEventListener('change', function() {
                    const kabupatenId = this.value;
                    const kabupatenNama = this.options[this.selectedIndex].getAttribute('data-name');

                    kabupatenIdInput.value = kabupatenId;
                    kabupatenNamaInput.value = kabupatenNama;

                    kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';
                    kecamatanIdInput.value = '';
                    kecamatanNamaInput.value = '';
                    kelurahanIdInput.value = '';
                    kelurahanNamaInput.value = '';

                    if (kabupatenId) {
                        fetch(`/kecamatan/${kabupatenId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(item => {
                                    const option = new Option(item.name, item.id);
                                    option.setAttribute('data-name', item.name);
                                    kecamatanSelect.add(option);
                                });
                            });
                    }
                });

                kecamatanSelect.addEventListener('change', function() {
                    const kecamatanId = this.value;
                    const kecamatanNama = this.options[this.selectedIndex].getAttribute('data-name');

                    kecamatanIdInput.value = kecamatanId;
                    kecamatanNamaInput.value = kecamatanNama;

                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';
                    kelurahanIdInput.value = '';
                    kelurahanNamaInput.value = '';

                    if (kecamatanId) {
                        fetch(`/kelurahan/${kecamatanId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(item => {
                                    const option = new Option(item.name, item.id);
                                    option.setAttribute('data-name', item.name);
                                    kelurahanSelect.add(option);
                                });
                            });
                    }
                });

                kelurahanSelect.addEventListener('change', function() {
                    const kelurahanId = this.value;
                    const kelurahanNama = this.options[this.selectedIndex].getAttribute('data-name');

                    kelurahanIdInput.value = kelurahanId;
                    kelurahanNamaInput.value = kelurahanNama;
                });

                // Format Rupiah
                const inputPengajuan = document.getElementById('nominal_pengajuan');
                const inputDisetujui = document.getElementById('nominal_disetujui');

                [inputPengajuan, inputDisetujui].forEach(input => {
                    if (!input) return;

                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/[^0-9]/g, '');
                        e.target.value = value ? formatRupiah(value) : '';
                    });

                    if (input.value) {
                        input.value = formatRupiah(input.value.replace(/[^0-9]/g, ''));
                    }
                });

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
            });
        </script>
    @endpush
@endsection
