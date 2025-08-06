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
                                        <div class="form-text">Pilih kecamatan sesuai dengan wilayah pengajuan yang berada
                                            di Kabupaten Probolinggo.</div>
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
                                            placeholder="Contoh: Rp 1.000.000">
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
                                        <label class="form-label">Setuju / Tidak Setuju</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status"
                                            required>
                                            <option value="">-- Pilih Status Persetujuan --</option>
                                            <option value="disetujui"
                                                {{ old('status', $proposal->status) == 'disetujui' ? 'selected' : '' }}>
                                                Setuju</option>
                                            <option value="pending"
                                                {{ old('status', $proposal->status) == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="ditolak"
                                                {{ old('status', $proposal->status) == 'ditolak' ? 'selected' : '' }}>Tolak
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
                                            placeholder="Contoh: Rp 1.000.000">
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
            $(document).ready(function() {
                let kecamatanIdValue = "{{ old('kecamatan_id', $proposal->kecamatan_id) }}";
                let kecamatanNamaValue = "{{ old('kecamatan_nama', $proposal->kecamatan_nama) }}";
                let kelurahanIdValue = "{{ old('kelurahan_id', $proposal->kelurahan_id) }}";
                let kelurahanNamaValue = "{{ old('kelurahan_nama', $proposal->kelurahan_nama) }}";

                // Init Select2
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

                // Fetch Kecamatan
                fetch('/kecamatan')
                    .then(res => res.json())
                    .then(data => {
                        const kecSelect = $('#kecamatan');
                        kecSelect.empty().append('<option></option>');

                        data.forEach(group => {
                            const optgroup = document.createElement('optgroup');
                            optgroup.label = group.label;

                            group.options.forEach(item => {
                                const option = new Option(item.name, item.id, false, item.id ==
                                    kecamatanIdValue);
                                optgroup.appendChild(option);
                            });

                            kecSelect.append(optgroup);
                        });

                        if (kecamatanIdValue) {
                            $('#kecamatan').val(kecamatanIdValue).trigger('change');
                            $('#kecamatan_id').val(kecamatanIdValue);
                            $('#kecamatan_nama').val(kecamatanNamaValue);
                            fetchKelurahan(kecamatanIdValue, kelurahanIdValue);
                        }
                    });


                $('#kecamatan').on('change', function() {
                    const selectedId = $(this).val();
                    const selectedText = $(this).find("option:selected").text();

                    $('#kecamatan_id').val(selectedId);
                    $('#kecamatan_nama').val(selectedText);

                    $('#kelurahan').empty().trigger('change');
                    fetchKelurahan(selectedId);
                });

                $('#kelurahan').on('change', function() {
                    const selectedId = $(this).val();
                    const selectedText = $(this).find("option:selected").text();
                    $('#kelurahan_id').val(selectedId);
                    $('#kelurahan_nama').val(selectedText);
                });

                function fetchKelurahan(kecamatanId, selectedKelurahanId = null) {
                    fetch(`/kelurahan/${kecamatanId}`)
                        .then(res => res.json())
                        .then(data => {
                            const kelSelect = $('#kelurahan');
                            kelSelect.empty().append('<option></option>');

                            data.forEach(item => {
                                const option = new Option(item.name, item.id, false, item.id ==
                                    selectedKelurahanId);
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

                // Event input untuk format saat ngetik
                [pengajuanInput, disetujuiInput].forEach(input => {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/[^0-9]/g, '');
                        if (value) {
                            e.target.value = formatRupiah(value);
                        } else {
                            e.target.value = '';
                        }
                    });

                    // Format ulang value default saat halaman pertama dimuat
                    if (input.value) {
                        input.value = formatRupiah(input.value.replace(/[^0-9]/g, ''));
                    }
                });
            });
        </script>
    @endpush
@endsection
