@extends('layouts.app')
@section('title', 'Edit Data Proposal')
@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
            rel="stylesheet" />
    @endpush
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Data Proposal</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('proposal.update', $proposal->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Judul Pengajuan</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                        name="judul" value="{{ old('judul', $proposal->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Instansi Pengajuan</label>
                                    <input type="text"
                                        class="form-control @error('instansi_pengajuan') is-invalid @enderror"
                                        name="instansi_pengajuan"
                                        value="{{ old('instansi_pengajuan', $proposal->instansi_pengajuan) }}" required>
                                    @error('instansi_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Metode Input Wilayah</label>
                                        <select id="metode_input" name="metode_input" class="form-select" required>
                                            <option value="auto"
                                                {{ old('metode_input', $proposal->kabupaten_id ? 'auto' : 'manual') == 'auto' ? 'selected' : '' }}>
                                                Otomatis (Dropdown)
                                            </option>
                                            <option value="manual"
                                                {{ old('metode_input', $proposal->kabupaten_id ? 'auto' : 'manual') == 'manual' ? 'selected' : '' }}>
                                                Manual (Input)
                                            </option>
                                        </select>
                                    </div>
                                    <div id="wilayah_auto"
                                        class="{{ old('metode_input', $proposal->kabupaten_id ? 'auto' : 'manual') == 'auto' ? '' : 'd-none' }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kabupaten / Kota</label>
                                                <select id="kabupaten"
                                                    class="form-select select2 @error('kabupaten_id') is-invalid @enderror"
                                                    style="width: 100%">
                                                    <option></option>
                                                </select>
                                                <input type="hidden" name="kabupaten_id" id="kabupaten_id"
                                                    value="{{ old('kabupaten_id', $proposal->kabupaten_id) }}">
                                                <input type="hidden" name="kabupaten_nama" id="kabupaten_nama"
                                                    value="{{ old('kabupaten_nama', $proposal->kabupaten_nama) }}">
                                                <div class="form-text">Pilih Kabupaten atau Kota sesuai wilayah pengajuan.
                                                </div>
                                                @error('kabupaten_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kecamatan</label>
                                                <select id="kecamatan"
                                                    class="form-select select2 @error('kecamatan_id') is-invalid @enderror"
                                                    style="width: 100%">
                                                    <option></option>
                                                </select>
                                                <input type="hidden" name="kecamatan_id" id="kecamatan_id"
                                                    value="{{ old('kecamatan_id', $proposal->kecamatan_id) }}">
                                                <input type="hidden" name="kecamatan_nama" id="kecamatan_nama"
                                                    value="{{ old('kecamatan_nama', $proposal->kecamatan_nama) }}">
                                                <div class="form-text">Pilih kecamatan sesuai dengan wilayah pengajuan yang
                                                    berada
                                                    di Kabupaten.</div>
                                                @error('kecamatan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kelurahan / Desa</label>
                                                <select id="kelurahan"
                                                    class="form-select select2 @error('kelurahan_id') is-invalid @enderror"
                                                    style="width: 100%">
                                                    <option></option>
                                                </select>
                                                <input type="hidden" name="kelurahan_id" id="kelurahan_id"
                                                    value="{{ old('kelurahan_id', $proposal->kelurahan_id) }}">
                                                <input type="hidden" name="kelurahan_nama" id="kelurahan_nama"
                                                    value="{{ old('kelurahan_nama', $proposal->kelurahan_nama) }}">
                                                <div class="form-text">Pilih kelurahan atau desa sesuai kecamatan terpilih.
                                                </div>
                                                @error('kelurahan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="wilayah_manual"
                                    class="{{ old('metode_input', $proposal->kabupaten_id ? 'auto' : 'manual') == 'manual' ? '' : 'd-none' }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kabupaten / Kota</label>
                                            <input type="text" name="kabupaten_manual" class="form-control"
                                                value="{{ old('kabupaten_manual', !$proposal->kabupaten_id ? $proposal->kabupaten_nama : '') }}"
                                                placeholder="Ketik nama kabupaten/kota">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kecamatan</label>
                                            <input type="text" name="kecamatan_manual" class="form-control"
                                                value="{{ old('kecamatan_manual', !$proposal->kecamatan_id ? $proposal->kecamatan_nama : '') }}"
                                                placeholder="Ketik nama kecamatan">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kelurahan / Desa</label>
                                            <input type="text" name="kelurahan_manual" class="form-control"
                                                value="{{ old('kelurahan_manual', !$proposal->kelurahan_id ? $proposal->kelurahan_nama : '') }}"
                                                placeholder="Ketik nama kelurahan/desa">
                                        </div>
                                    </div>
                                </div>





                                <div class="mb-3">
                                    <label class="form-label">Tanggal Disposisi</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_disposisi') is-invalid @enderror"
                                        name="tanggal_disposisi"
                                        value="{{ old('tanggal_disposisi', $proposal->tanggal_disposisi) }}" required>
                                    @error('tanggal_disposisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nominal Pengajuan</label>
                                        <input type="text" id="nominal_pengajuan" name="nominal_pengajuan"
                                            class="form-control @error('nominal_pengajuan') is-invalid @enderror"
                                            value="{{ old('nominal_pengajuan', $proposal->nominal_pengajuan ?? '') }}"
                                            placeholder="Masukkan Angka">
                                        @error('nominal_pengajuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Barang Pengajuan</label>
                                        <input type="text"
                                            class="form-control @error('barang_pengajuan') is-invalid @enderror"
                                            name="barang_pengajuan"
                                            value="{{ old('barang_pengajuan', $proposal->barang_pengajuan) }}">
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
                                                    {{ old('tipologi_id', $proposal->tipologi_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->kode }} - {{ $item->deskripsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tipologi_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Setuju / Pending / Tolak</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status"
                                            required>
                                            <option value="">-- Pilih Status Persetujuan --</option>
                                            <option value="setuju"
                                                {{ old('status', $proposal->status) == 'setuju' ? 'selected' : '' }}>
                                                Setuju
                                            </option>
                                            <option value="pending"
                                                {{ old('status', $proposal->status) == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="tolak"
                                                {{ old('status', $proposal->status) == 'tolak' ? 'selected' : '' }}>
                                                Tolak
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nominal Disetujui</label>
                                        <input type="text" id="nominal_disetujui" name="nominal_disetujui"
                                            class="form-control @error('nominal_disetujui') is-invalid @enderror"
                                            value="{{ old('nominal_disetujui', $proposal->nominal_disetujui ?? '') }}"
                                            placeholder="Masukkan Angka">
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
                                            name="barang_disetujui"
                                            value="{{ old('barang_disetujui', $proposal->barang_disetujui) }}">
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
                                        name="nama_pic_id" value="{{ old('nama_pic_id', $proposal->namapic->nama) }}"
                                        disabled>
                                    <div class="form-text">Nama PIC diatur secara otomatis sesuai dengan pengguna yang
                                        membuat laporan proposal.</div>
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
                                            <option value="{{ $item->id }}"
                                                {{ old('tipe_proses_id', $proposal->tipe_proses_id) == $item->id ? 'selected' : '' }}>
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
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                        name="keterangan" value="{{ old('keterangan', $proposal->keterangan) }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Overdue</label>
                                    <input type="date" class="form-control @error('overdue') is-invalid @enderror"
                                        name="overdue" value="{{ old('overdue', $proposal->overdue) }}">
                                    @error('overdue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" style="background-color: #78C841; color: white;"
                                    class="btn">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const metodeInput = document.getElementById('metode_input');
                const wilayahAuto = document.getElementById('wilayah_auto');
                const wilayahManual = document.getElementById('wilayah_manual');

                metodeInput.addEventListener('change', function() {
                    if (this.value === 'auto') {
                        wilayahAuto.classList.remove('d-none');
                        wilayahManual.classList.add('d-none');
                    } else {
                        wilayahAuto.classList.add('d-none');
                        wilayahManual.classList.remove('d-none');
                    }
                });
            });
        </script>

        <script>
            function formatRupiah(input) {
                // Hapus karakter selain angka
                let angka = input.value.replace(/[^0-9]/g, "");

                // Format dengan titik ribuan
                input.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            document.addEventListener("DOMContentLoaded", function() {
                const fields = ["nominal_pengajuan", "nominal_disetujui"];

                fields.forEach(id => {
                    const input = document.getElementById(id);

                    if (input) {
                        // Format ulang saat halaman dimuat
                        input.value = input.value.replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                        // Format saat mengetik
                        input.addEventListener("input", function() {
                            formatRupiah(this);
                        });
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                let kabupatenIdValue = "{{ old('kabupaten_id', $proposal->kabupaten_id) }}";
                let kabupatenNamaValue = "{{ old('kabupaten_nama', $proposal->kabupaten_nama) }}";
                let kecamatanIdValue = "{{ old('kecamatan_id', $proposal->kecamatan_id) }}";
                let kecamatanNamaValue = "{{ old('kecamatan_nama', $proposal->kecamatan_nama) }}";
                let kelurahanIdValue = "{{ old('kelurahan_id', $proposal->kelurahan_id) }}";
                let kelurahanNamaValue = "{{ old('kelurahan_nama', $proposal->kelurahan_nama) }}";

                // Init Select2
                $('#kabupaten').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Pilih Kabupaten / Kota --',
                    allowClear: true
                });

                $('#kecamatan').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Pilih Kecamatan --',
                    allowClear: true
                });

                $('#kelurahan').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Pilih Kelurahan / Desa --',
                    allowClear: true
                });

                // Fetch Kabupaten
                fetch('/kabupaten')
                    .then(res => res.json())
                    .then(data => {
                        const kabSelect = $('#kabupaten');
                        kabSelect.empty().append('<option></option>');

                        data.forEach(item => {
                            const option = new Option(item.name, item.id, false, item.id ==
                                kabupatenIdValue);
                            option.setAttribute('data-name', item.name);
                            kabSelect.append(option);
                        });

                        if (kabupatenIdValue) {
                            $('#kabupaten').val(kabupatenIdValue).trigger('change');
                            $('#kabupaten_id').val(kabupatenIdValue);
                            $('#kabupaten_nama').val(kabupatenNamaValue);
                            fetchKecamatan(kabupatenIdValue, kecamatanIdValue);
                        }
                    });

                $('#kabupaten').on('change', function() {
                    const selectedId = $(this).val();
                    const selectedText = $(this).find("option:selected").text();

                    $('#kabupaten_id').val(selectedId);
                    $('#kabupaten_nama').val(selectedText);

                    $('#kecamatan').empty().trigger('change');
                    $('#kelurahan').empty().trigger('change');

                    $('#kecamatan_id').val('');
                    $('#kecamatan_nama').val('');
                    $('#kelurahan_id').val('');
                    $('#kelurahan_nama').val('');

                    if (selectedId) {
                        fetchKecamatan(selectedId);
                    }
                });

                $('#kecamatan').on('change', function() {
                    const selectedId = $(this).val();
                    const selectedText = $(this).find("option:selected").text();

                    $('#kecamatan_id').val(selectedId);
                    $('#kecamatan_nama').val(selectedText);

                    $('#kelurahan').empty().trigger('change');
                    $('#kelurahan_id').val('');
                    $('#kelurahan_nama').val('');

                    if (selectedId) {
                        fetchKelurahan(selectedId);
                    }
                });

                $('#kelurahan').on('change', function() {
                    const selectedId = $(this).val();
                    const selectedText = $(this).find("option:selected").text();

                    $('#kelurahan_id').val(selectedId);
                    $('#kelurahan_nama').val(selectedText);
                });

                function fetchKecamatan(kabupatenId, selectedKecamatanId = null) {
                    fetch(`/kecamatan/${kabupatenId}`)
                        .then(res => res.json())
                        .then(data => {
                            const kecSelect = $('#kecamatan');
                            kecSelect.empty().append('<option></option>');

                            data.forEach(item => {
                                const option = new Option(item.name, item.id, false, item.id ==
                                    selectedKecamatanId);
                                option.setAttribute('data-name', item.name);
                                kecSelect.append(option);
                            });

                            if (selectedKecamatanId) {
                                $('#kecamatan').val(selectedKecamatanId).trigger('change');
                                $('#kecamatan_id').val(selectedKecamatanId);
                                $('#kecamatan_nama').val(kecamatanNamaValue);
                                fetchKelurahan(selectedKecamatanId, kelurahanIdValue);
                            }
                        });
                }

                function fetchKelurahan(kecamatanId, selectedKelurahanId = null) {
                    fetch(`/kelurahan/${kecamatanId}`)
                        .then(res => res.json())
                        .then(data => {
                            const kelSelect = $('#kelurahan');
                            kelSelect.empty().append('<option></option>');

                            data.forEach(item => {
                                const option = new Option(item.name, item.id, false, item.id ==
                                    selectedKelurahanId);
                                option.setAttribute('data-name', item.name);
                                kelSelect.append(option);
                            });

                            if (selectedKelurahanId) {
                                $('#kelurahan').val(selectedKelurahanId).trigger('change');
                                $('#kelurahan_id').val(selectedKelurahanId);
                                $('#kelurahan_nama').val(kelurahanNamaValue);
                            }
                        });
                }
            });
        </script>

        {{-- FORMAT RUPIAH --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pengajuanInput = document.getElementById('nominal_pengajuan');
                const disetujuiInput = document.getElementById('nominal_disetujui');

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

                // [pengajuanInput, disetujuiInput].forEach(input => {
                //     input.addEventListener('input', function(e) {
                //         let value = e.target.value.replace(/[^0-9]/g, '');
                //         if (value) {
                //             e.target.value = formatRupiah(value);
                //         } else {
                //             e.target.value = '';
                //         }
                //     });

                //     if (input.value) {
                //         input.value = formatRupiah(input.value.replace(/[^0-9]/g, ''));
                //     }
                // });
                input.addEventListener('input', function(e) {
                    let raw = e.target.value; // nilai asli dari input

                    // Kalau user isi "-", langsung biarkan tanpa format
                    if (raw === '-') {
                        return; // biarkan apa adanya
                    }

                    // Kalau bukan "-", baru kita bersihkan ke angka
                    let value = raw.replace(/[^0-9]/g, '');
                    e.target.value = value ? formatRupiah(value) : '';
                });

            });
        </script>
    @endpush
@endsection
