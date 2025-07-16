 @extends('layouts.app')
 @section('title', 'CSR PLN Nusantara Power UP Paiton')
 @section('content')
     @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    @endpush
     <div class="row">
         <div class="col-lg-12 d-flex align-items-stretch">
             <div class="card w-100">
                 <div class="card-body p-4">
                     <h5 class="card-title fw-semibold mb-4">Data Proposal</h5>
                     <div class="mb-3 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-1"></i> Tambah Proposal
                    </button>
                </div>

                     <div class="table-responsive">
                        <table id="proposalTable" class="table table-bordered text-nowrap mb-0 align-middle">
                             <thead class="text-dark fs-4">
                                 <tr>
                                     <th>
                                         <h6 class="fw-semibold mb-0">No</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Judul</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Instansi</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Lokasi</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Tanggal</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Nominal Pengajuan</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Barang Pengajuan</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Aksi</h6>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($proposal as $data)
                                     <tr>
                                         <td>
                                             <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                         </td>
                                         <td>
                                             <h6 class="fw-semibold mb-0">{{ $data->judul }}</h6>
                                             {{-- <span class="fw-normal">{{ $data->deskripsi }}</span> --}}
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->instansi_pengajuan }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->lokasi }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->tanggal_disposisi }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->nominal_pengajuan }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->barang_pengajuan }}</p>
                                         </td>
                                         <td>
                                             <div class="dropdown">
                                                 <button class="btn btn-sm btn-light border-0" type="button"
                                                     id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown"
                                                     aria-expanded="false">
                                                     <i class="fas fa-ellipsis-h"></i> {{-- tiga titik horizontal --}}
                                                 </button>
                                                 <ul class="dropdown-menu"
                                                     aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                                      <button type="button"
                                                            class="dropdown-item text-primary btn-edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal"
                                                            data-id="{{ $data->id }}"
                                                            data-kode="{{ $data->kode }}"
                                                            data-deskripsi="{{ $data->deskripsi }}">
                                                            Edit
                                                        </button>
                                                           <button type="button"
        class="dropdown-item text-danger btn-delete"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-id="{{ $data->id }}"
        data-nama="{{ $data->kode }}">
        Hapus
    </button>
                                                     </li>
                                                 </ul>
                                             </div>
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tipologi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="edit-kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit-deskripsi" name="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tipologi.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Tipologi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create-kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="create-kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="create-deskripsi" name="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-4">Apakah Anda yakin ingin menghapus data berikut?</p>
                    <div class="alert alert-primary mb-0">
                        <strong id="deleteDataName"></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>


     @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
                $('#proposalTable').DataTable({
            language: {
                search: "Cari",
                lengthMenu: "Tampil _MENU_",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0–0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "«",
                    last: "»",
                    previous: "‹",
                    next: "›"
                }
            },
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            pagingType: "full_numbers",
            drawCallback: function(settings) {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            }
        });
        </script>

{{-- EDIT MODAL --}}
        <script>
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        const kode = $(this).data('kode');
        const deskripsi = $(this).data('deskripsi');

        $('#edit-kode').val(kode);
        $('#edit-deskripsi').val(deskripsi);

        // Update action form dengan ID yang dipilih
        $('#editForm').attr('action', '/tipologi/' + id);
    });
</script>

{{-- DELETE MODAL --}}
<script>
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#deleteDataName').text("Kode: " + nama);
        $('#deleteForm').attr('action', '/tipologi/' + id);
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
