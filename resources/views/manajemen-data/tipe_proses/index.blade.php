@extends('layouts.app')
@section('title', 'Data Tipe Proses')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Data Tipe Proses</h5>
                {{-- <div class="mb-3 text-end">
                    <a href="{{ route('tipe-proses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Tipe Proses
                    </a>
                </div> --}}
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTipeModal">
                        <i class="fas fa-plus me-1"></i> Tambah Tipe Proses
                    </button>
                </div>


                @foreach ($tipeProses as $proses)
                    <div class="mb-4">
                        <h6 class="fw-bold">{{ $proses->nama }}</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Nama Sub Proses</th>
                                        <th style="width: 20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proses->subProses->sortBy('order_index') as $sub)
                                        <tr>
                                            <td>{{ $sub->order_index }}</td>
                                            <td>{{ $sub->nama_sub }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light border-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <button type="button"
                                                            class="dropdown-item text-primary btn-edit-sub"
                                                            data-id="{{ $sub->id }}"
                                                            data-nama="{{ $sub->nama_sub }}"
                                                            data-order="{{ $sub->order_index }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSubModal">
                                                            Edit
                                                        </button>
                                                        <button type="button"
                                                            class="dropdown-item text-danger btn-delete-sub"
                                                            data-id="{{ $sub->id }}"
                                                            data-nama="{{ $sub->nama_sub }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteSubModal">
                                                            Hapus
                                                        </button>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($proses->subProses->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada sub proses</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="text-end mt-2">
                            <a href="{{ route('sub-proses.create', ['tipe_proses_id' => $proses->id]) }}"
                               class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Tambah Sub Proses
                            </a>
                        </div> --}}
                        <div class="text-end mt-2">
                            <button type="button" class="btn btn-sm btn-success btn-add-sub"
                                data-tipe="{{ $proses->id }}" data-bs-toggle="modal" data-bs-target="#createSubModal">
                                <i class="fas fa-plus"></i> Tambah Sub Proses
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Sub Proses --}}
<!-- Modal Tambah Sub Proses -->
<div class="modal fade" id="createSubModal" tabindex="-1" aria-labelledby="createSubLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="createSubForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sub Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tipe_proses_id" id="create-tipe-id">
                    <div class="mb-3">
                        <label for="create-sub-nama" class="form-label">Nama Sub Proses</label>
                        <input type="text" class="form-control" id="create-sub-nama" name="nama_sub" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-sub-order" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="create-sub-order" name="order_index" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Modal Tambah Tipe Proses -->
<div class="modal fade" id="createTipeModal" tabindex="-1" aria-labelledby="createTipeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tipe-proses.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tipe Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_tipe" class="form-label">Nama Tipe Proses</label>
                        <input type="text" class="form-control" id="nama_tipe" name="nama" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Edit Sub Proses -->
<div class="modal fade" id="editSubModal" tabindex="-1" aria-labelledby="editSubLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editSubForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-sub-nama" class="form-label">Nama Sub Proses</label>
                        <input type="text" class="form-control" id="edit-sub-nama" name="nama_sub" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="edit-sub-order" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="edit-sub-order" name="order_index" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Sub Proses -->
<div class="modal fade" id="deleteSubModal" tabindex="-1" aria-labelledby="deleteSubLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteSubForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus sub proses berikut?</p>
                    <div class="alert alert-primary mb-0" id="deleteSubText"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
 @if (session('success'))
    <div class="position-fixed top-0 end-0 p-3 mt-5 me-5" style="z-index: 9999">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-add-sub', function () {
        const tipeId = $(this).data('tipe');
        $('#create-tipe-id').val(tipeId);
        $('#createSubForm').attr('action', '/sub-proses');
    });
</script>

<script>
    $(document).on('click', '.btn-edit-sub', function () {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const order = $(this).data('order');

        $('#edit-sub-nama').val(nama);
        $('#edit-sub-order').val(order);
        $('#editSubForm').attr('action', '/sub-proses/' + id);
    });

    $(document).on('click', '.btn-delete-sub', function () {
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#deleteSubText').text("Sub Proses: " + nama);
        $('#deleteSubForm').attr('action', '/sub-proses/' + id);
    });
</script>
{{-- TOAST --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(function (toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 8000,
            });
            toast.show();
        });
    });
</script>
@endpush
