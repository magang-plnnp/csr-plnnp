 @extends('layouts.app')
 @section('title', 'CSR PLN Nusantara Power UP Paiton')
 @push('styles')
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
     <style>
         /* Warna tombol pagination aktif dari DataTables (Bootstrap 5) */
         .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
             background-color: #78C841 !important;
             border-color: #78C841 !important;
             color: white !important;
         }

         /* Opsional: hover untuk tombol aktif */
         .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link:hover {
             background-color: #66b638 !important;
             color: white !important;
         }
         
     </style>
 @endpush
 @section('content')
     <div class="row">
         <div class="col-lg-12 d-flex align-items-stretch">
             <div class="card w-100">
                 <div class="card-body p-4">
                     <h5 class="card-title fw-semibold mb-4">Data Kelayakan</h5>
                     <div class="mb-3 text-end">
                         <button style="background-color: #78C841; color: white;" class="btn" data-bs-toggle="modal"
                             data-bs-target="#createModal">
                             <i class="fas fa-plus me-1"></i> Tambah Kelayakan
                         </button>
                     </div>

                     <div class="table-responsive">
                         <table id="tipologiTable" class="table table-bordered text-nowrap mb-0 align-middle">
                             <thead class="text-dark fs-4">
                                 <tr>
                                     <th>
                                         <h6 class="fw-semibold mb-0">No</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Proposal</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Dasar Pelaksanaan</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Latar Belakang</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Tujuan</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">File</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Aksi</h6>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($kelayakan as $data)
                                     <tr>
                                         <td>
                                             <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                         </td>
                                         <td style="white-space: normal;">
                                             <h6 class="fw-semibold mb-0">{{ $data->proposal->judul }}</h6>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->dasar_pelaksanaan }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->latar_belakang }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->tujuan }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal"> <a href="{{ asset('storage/' . $data->file_pdf) }}"
                                                     target="_blank" class="btn btn-sm btn-primary">
                                                     PDF
                                                 </a></p>
                                         </td>
                                         <td>
                                             <div class="d-flex justify-content-center align-items-center gap-2">
                                                 {{-- Tombol Edit --}}
                                                 <button type="button"
                                                     class="btn btn-sm btn-light border-0 text-primary btn-edit"
                                                     data-bs-toggle="modal" data-bs-target="#editModal"
                                                     data-id="{{ $data->id }}" data-kode="{{ $data->kode }}"
                                                     data-deskripsi="{{ $data->deskripsi }}">
                                                     <i class="fas fa-edit"></i>
                                                 </button>

                                                 {{-- Tombol Hapus --}}
                                                 <button type="button"
                                                     class="btn btn-sm btn-light border-0 text-danger btn-delete"
                                                     data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                     data-id="{{ $data->id }}" data-nama="{{ $data->kode }}">
                                                     <i class="fas fa-trash-alt"></i>
                                                 </button>
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
                         <h5 class="modal-title" id="editModalLabel">Edit Form Kelayakaan</h5>
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
                         <button type="button" class="btn bg-secondary-subtle text-dark"
                             data-bs-dismiss="modal">Batal</button>
                         <button type="submit" style="background-color: #78C841; color: white;" class="btn">Simpan
                             Perubahan</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>

     <!-- Modal Create -->
     <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <form method="POST" action="{{ route('kelayakan.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Form Kelayakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Proposal</label>
                            <select name="proposal_id" class="form-control @error('proposal_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Proposal --</option>
                                @foreach ($proposal as $item)
                                    <option value="{{ $item->id }}" {{ old('proposal_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proposal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dasar_pelaksanaan" class="form-label">Dasar Pelaksanaan</label>
                            <textarea class="form-control" id="dasar_pelaksanaan" name="dasar_pelaksanaan" required>{{ old('dasar_pelaksanaan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="latar_belakang" class="form-label">Latar Belakang</label>
                            <textarea class="form-control" id="latar_belakang" name="latar_belakang" required>{{ old('latar_belakang') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" required>{{ old('tujuan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="indikator_lingkungan" class="form-label">Indikator Lingkungan</label>
                            <textarea class="form-control" id="indikator_lingkungan" name="indikator_lingkungan">{{ old('indikator_lingkungan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="indikator_sosial" class="form-label">Indikator Sosial</label>
                            <textarea class="form-control" id="indikator_sosial" name="indikator_sosial">{{ old('indikator_sosial') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_penerima_manfaat" class="form-label">Jumlah Penerima Manfaat</label>
                            <input type="text" class="form-control" name="jumlah_penerima_manfaat" id="jumlah_penerima_manfaat" value="{{ old('jumlah_penerima_manfaat') }}">
                        </div>

                        <div class="mb-3">
                            <label for="jenis_stakeholder" class="form-label">Jenis Stakeholder</label>
                            <input type="text" class="form-control" name="jenis_stakeholder" id="jenis_stakeholder" value="{{ old('jenis_stakeholder') }}">
                        </div>

                        <div class="mb-3">
                            <label for="pejabat_instansi" class="form-label">Pejabat Instansi</label>
                            <input type="text" class="form-control" name="pejabat_instansi" id="pejabat_instansi" value="{{ old('pejabat_instansi') }}">
                        </div>

                        <div class="mb-3">
                            <label for="data_terdahulu" class="form-label">Data Terdahulu</label>
                            <input type="text" class="form-control" name="data_terdahulu" id="data_terdahulu" value="{{ old('data_terdahulu') }}">
                        </div>

                        <div class="mb-3">
                            <label for="prioritas" class="form-label">Prioritas</label>
                            <select name="prioritas" id="prioritas" class="form-control" required>
                                <option value="">-- Pilih Prioritas --</option>
                                <option value="1">Prioritas 1</option>
                                <option value="2">Prioritas 2</option>
                                <option value="3">Prioritas 3</option>
                                <option value="4">Prioritas 4</option>
                                <option value="5">Prioritas 5</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dampak" class="form-label">Dampak</label>
                            <select name="dampak" id="dampak" class="form-control" required>
    <option value="">-- Pilih Dampak --</option>
    <option value="1">Tidak ada dampak</option>
    <option value="2">Kecil</option>
    <option value="3">Sedang</option>
    <option value="4">Tinggi</option>
    <option value="5">Sangat Tinggi</option>
</select>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_khusus" class="form-label">Catatan Khusus</label>
                            <textarea class="form-control" id="catatan_khusus" name="catatan_khusus">{{ old('catatan_khusus') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-secondary-subtle text-dark" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" style="background-color: #78C841; color:whitesmoke" class="btn">Tambah</button>
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
                         <button type="button" class="btn bg-secondary-subtle text-dark"
                             data-bs-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>


     @push('scripts')
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

         <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



         <script>
             $('#tipologiTable').DataTable({
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
                 lengthMenu: [
                     [10, 25, 50, -1],
                     [10, 25, 50, "Semua"]
                 ],
                 pagingType: "full_numbers",
                 drawCallback: function(settings) {
                     $('.dataTables_paginate > .pagination').addClass('pagination-sm');
                 }
             });
         </script>

         {{-- EDIT MODAL --}}
         <script>
             $(document).on('click', '.btn-edit', function() {
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
             $(document).on('click', '.btn-delete', function() {
                 const id = $(this).data('id');
                 const nama = $(this).data('nama');

                 $('#deleteDataName').text("Kode: " + nama);
                 $('#deleteForm').attr('action', '/tipologi/' + id);
             });
         </script>

         {{-- TOAST --}}
         <script>
             document.addEventListener("DOMContentLoaded", function() {
                 const toastElList = [].slice.call(document.querySelectorAll('.toast'))
                 toastElList.map(function(toastEl) {
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
             <div style="background-color: #78C841; color: white;" class="toast align-items-center border-0 show"
                 role="alert" aria-live="assertive" aria-atomic="true">
                 <div class="d-flex">
                     <div class="toast-body">
                         {{ session('success') }}
                     </div>
                     <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                         aria-label="Close"></button>
                 </div>
             </div>
         </div>
     @endif


 @endsection
