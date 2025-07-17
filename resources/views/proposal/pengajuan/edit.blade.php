@extends('layouts.app')
@section('title', 'Edit Data Proposal')
@section('content')
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
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $proposal->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Instansi Pengajuan</label>
                                    <input type="text" class="form-control @error('instansi_pengajuan') is-invalid @enderror" name="instansi_pengajuan" value="{{ old('instansi_pengajuan', $proposal->instansi_pengajuan) }}" required>
                                    @error('instansi_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{ old('lokasi', $proposal->lokasi) }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Disposisi</label>
                                    <input type="date" class="form-control @error('tanggal_disposisi') is-invalid @enderror" name="tanggal_disposisi" value="{{ old('tanggal_disposisi', $proposal->tanggal_disposisi) }}" required>
                                    @error('tanggal_disposisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nominal Pengajuan</label>
                                    <input type="number" class="form-control @error('nominal_pengajuan') is-invalid @enderror" name="nominal_pengajuan" value="{{ old('nominal_pengajuan', $proposal->nominal_pengajuan) }}">
                                    @error('nominal_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Barang Pengajuan</label>
                                    <input type="text" class="form-control @error('barang_pengajuan') is-invalid @enderror" name="barang_pengajuan" value="{{ old('barang_pengajuan', $proposal->barang_pengajuan) }}">
                                    @error('barang_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tipologi</label>
                                    <select name="tipologi_id" class="form-control @error('tipologi_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tipologi --</option>
                                        @foreach ($tipologi as $item)
                                            <option value="{{ $item->id }}" {{ old('tipologi_id', $proposal->tipologi_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode }} - {{ $item->deskripsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipologi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Setuju / Tidak Setuju</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="">-- Pilih Status Persetujuan --</option>
                                        <option value="disetuju" {{ old('status', $proposal->status) == 'disetuju' ? 'selected' : '' }}>Setuju</option>
                                        <option value="pending" {{ old('status', $proposal->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="ditolak" {{ old('status', $proposal->status) == 'ditolak' ? 'selected' : '' }}>Tolak</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nominal Disetujui</label>
                                    <input type="number" class="form-control @error('nominal_disetujui') is-invalid @enderror" name="nominal_disetujui" value="{{ old('nominal_disetujui', $proposal->nominal_disetujui) }}">
                                    @error('nominal_disetujui')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Barang Disetujui</label>
                                    <input type="text" class="form-control @error('barang_disetujui') is-invalid @enderror" name="barang_disetujui" value="{{ old('barang_disetujui', $proposal->barang_disetujui) }}">
                                    @error('barang_disetujui')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">PIC</label>
                                    <input type="text" class="form-control @error('nama_pic_id') is-invalid @enderror" name="nama_pic_id" value="{{ old('nama_pic_id', $proposal->nama_pic_id) }}" required>
                                    @error('nama_pic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Proses</label>
                                    <select name="tipe_proses_id" class="form-control @error('tipe_proses_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Proses --</option>
                                        @foreach ($proses as $item)
                                            <option value="{{ $item->id }}" {{ old('tipe_proses_id', $proposal->tipe_proses_id) == $item->id ? 'selected' : '' }}>
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
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan', $proposal->keterangan) }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Overdue</label>
                                    <input type="date" class="form-control @error('overdue') is-invalid @enderror" name="overdue" value="{{ old('overdue', $proposal->overdue) }}">
                                    @error('overdue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
