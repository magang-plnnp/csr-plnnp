 @extends('layouts.app')
 @section('title', 'CSR PLN Nusantara Power UP Paiton')
 @push('styles')
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
         rel="stylesheet" />

     <style>
         /* Warna tombol pagination aktif */
         .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
             background-color: #78C841 !important;
             border-color: #78C841 !important;
             color: white !important;
         }

         .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link:hover {
             background-color: #66b638 !important;
             color: white !important;
         }

         .table-responsive table {
             margin-left: 0 !important;
             width: 100% !important;
         }

         .dataTables_scrollBody {
             border-top: none !important;
         }

         /* Efek bayangan halus di sisi kanan kolom freeze */
         .dtfc-fixed-left {
             background: white;
             box-shadow: 3px 0 5px rgba(0, 0, 0, 0.1);
             z-index: 2 !important;
         }
     </style>
 @endpush
 @section('content')
     <div class="row">
         <div class="col-lg-12 d-flex align-items-stretch">
             <div class="card w-100">
                 <div class="card-body p-4">
                     <h5 class="card-title fw-semibold mb-4">Data Berita Acara</h5>
                     <div class="mb-3 text-end">
                         <button style="background-color: #78C841; color: white;" class="btn" data-bs-toggle="modal"
                             data-bs-target="#createModal">
                             <i class="fas fa-plus me-1"></i> Tambah Berita Acara
                         </button>
                     </div>
                     <div class="table-responsive">
                         <table id="tipologiTable" class="table table-bordered mb-0 align-middle">
                             <thead class="text-dark fs-4">
                                 <tr>
                                     <th>
                                         <h6 class="fw-semibold mb-0">No</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Proposal</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Nama</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Jabatan</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">File</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Upload</h6>
                                     </th>
                                     <th>
                                         <h6 class="fw-semibold mb-0">Aksi</h6>
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($beritaacara as $data)
                                     <tr>
                                         <td>
                                             <h6 class="fw-normal mb-0">{{ $loop->iteration }}</h6>
                                         </td>
                                         <td style="white-space: normal;">
                                             <h6 class="fw-normal mb-0">{{ $data->proposal->judul }}</h6>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->nama_penerima }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal">{{ $data->jabatan_penerima }}</p>
                                         </td>
                                         <td>
                                             <p class="mb-0 fw-normal"> <a href="{{ asset('storage/' . $data->file_pdf) }}"
                                                     target="_blank">Lihat
                                                     PDF</a></p>

                                         </td>
                                         <td class="text-center">
                                             @if ($data->file_upload)
                                                 <a href="{{ asset('storage/' . $data->file_upload) }}" target="_blank"
                                                     class="text-primary fw-normal">Lihat File</a>
                                             @else
                                                 <a href="#" class="text-primary fw-normal" data-bs-toggle="modal"
                                                     data-bs-target="#uploadModal" data-id="{{ $data->id }}">
                                                     Upload File
                                                 </a>
                                             @endif
                                         </td>

                                         <td>
                                             <div class="d-flex justify-content-center align-items-center gap-2">
                                                 {{-- Tombol Edit --}}
                                                 <button type="button"
                                                     class="btn btn-sm btn-light border-0 text-primary btn-edit"
                                                     data-bs-toggle="modal" data-bs-target="#editModal"
                                                     data-id="{{ $data->id }}"
                                                     data-proposal="{{ $data->proposal->judul }}"
                                                     data-nama="{{ $data->nama_penerima }}"
                                                     data-jabatan="{{ $data->jabatan_penerima }}">
                                                     <i class="fas fa-edit"></i>
                                                 </button>

                                                 {{-- Tombol Hapus --}}
                                                 <button type="button"
                                                     class="btn btn-sm btn-light border-0 text-danger btn-delete"
                                                     data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                     data-id="{{ $data->id }}"
                                                     data-nama="{{ $data->proposal->judul }}">
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
                         <h5 class="modal-title" id="editModalLabel">Edit Berita Acara</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                     </div>
                     <div class="modal-body">
                         <div class="mb-3">
                             <label for="edit-proposal" class="form-label">Proposal</label>
                             <input type="text" class="form-control" id="edit-proposal" disabled>
                         </div>
                         <div class="mb-3">
                             <label for="edit-nama" class="form-label">Nama Penerima</label>
                             <textarea class="form-control" id="edit-nama" name="nama_penerima" required></textarea>
                         </div>

                         <div class="mb-3">
                             <label for="edit-jabatan" class="form-label">Jabatan Penerima</label>
                             <textarea class="form-control" id="edit-jabatan" name="jabatan_penerima" required></textarea>
                         </div>


                         <div id="edit-bantuan-wrapper"></div>
                         <button type="button" id="edit-add-bantuan" class="btn btn-sm btn-secondary mb-3">+ Tambah
                             Jenis
                             Bantuan</button>
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
             <form method="POST" action="{{ route('berita-acara.store') }}">
                 @csrf
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="createModalLabel">Tambah Berita Acara</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                     </div>

                     <div class="modal-body">
                         <div class="mb-3">
                             <label class="form-label">Proposal</label>
                             <select name="proposal_id" id="select-proposal"
                                 class="form-select {{ $errors->has('proposal_id') ? 'is-invalid' : '' }}" required>
                                 <option value="">-- Pilih Proposal --</option>
                                 @foreach ($proposal as $item)
                                     <option value="{{ $item->id }}"
                                         {{ old('proposal_id') == $item->id ? 'selected' : '' }}>
                                         {{ $item->judul }}
                                     </option>
                                 @endforeach
                             </select>
                             @error('proposal_id')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="mb-3">
                             <label for="nama_penerima" class="form-label">Nama Pihak Kedua</label>
                             <textarea class="form-control" id="nama_penerima" name="nama_penerima" required>{{ old('nama_penerima') }}</textarea>
                         </div>

                         <div class="mb-3">
                             <label for="jabatan_penerima" class="form-label">Jabatan Pihak Kedua</label>
                             <textarea class="form-control" id="jabatan_penerima" name="jabatan_penerima" required>{{ old('jabatan_penerima') }}</textarea>
                         </div>

                         <div id="bantuan-wrapper">
                             <div class="bantuan-item mb-3 d-flex align-items-start gap-2">
                                 <div style="flex-grow:1;">
                                     <label class="form-label">Jenis Bantuan</label>
                                     <input type="text" name="jenis_bantuan[]" class="form-control mb-2"
                                         placeholder="Contoh: Bibit Alpukat" required>

                                     <label class="form-label">Jumlah</label>
                                     <input type="text" name="jumlah_bantuan[]" class="form-control"
                                         placeholder="Contoh: 500 buah" required>
                                 </div>
                                 <button type="button" class="btn btn-danger btn-remove"
                                     style="height: fit-content; margin-top: 28px;">&times;</button>
                             </div>
                         </div>

                         <button type="button" id="add-bantuan" class="btn btn-sm btn-secondary mb-3">
                             + Tambah Jenis Bantuan
                         </button>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn bg-secondary-subtle text-dark"
                             data-bs-dismiss="modal">Batal</button>
                         <button type="submit" style="background-color: #78C841; color:whitesmoke"
                             class="btn">Tambah</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>

     <!-- Modal Upload -->
     <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <form id="uploadForm" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="modal-header">
                         <h5 class="modal-title" id="uploadModalLabel">Upload File Berita Acara</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>

                     <div class="modal-body">
                         <input type="file" name="file_upload" id="fileInput" class="form-control" required>
                         <small class="text-muted">File yang diizinkan: PDF atau Gambar</small>

                         <div id="fileError" class="text-danger mt-2 d-none">
                             Format file tidak sesuai.
                         </div>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn bg-secondary-subtle text-dark"
                             data-bs-dismiss="modal">Batal</button>

                         <button type="submit" id="btnUpload" style="background-color: #78C841; color:white"
                             class="btn">
                             Upload
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>

     <script>
         const allowed = ['jpg', 'jpeg', 'png', 'heic', 'pdf'];
         const fileInput = document.getElementById('fileInput');
         const btnUpload = document.getElementById('btnUpload');
         const errorMsg = document.getElementById('fileError');

         fileInput.addEventListener('change', function() {
             const file = this.files[0];

             if (!file) return;

             const ext = file.name.split('.').pop().toLowerCase();

             if (!allowed.includes(ext)) {
                 errorMsg.classList.remove('d-none');
                 btnUpload.disabled = true;
             } else {
                 errorMsg.classList.add('d-none');
                 btnUpload.disabled = false;
             }
         });
     </script>

     <script>
         const uploadModal = document.getElementById('uploadModal');
         uploadModal.addEventListener('show.bs.modal', function(event) {
             const button = event.relatedTarget;
             const id = button.getAttribute('data-id');
             const form = document.getElementById('uploadForm');
             form.action = `/berita-acara/${id}/upload`;
         });
     </script>


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
         <!-- jQuery paling awal -->
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <!-- DataTables + Plugins -->
         <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
         <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
         <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
         <!-- Select2 -->
         <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

         <script>
             $(document).ready(function() {
                         $('#select-proposal').select2({
                             theme: 'bootstrap4',
                             allowClear: true,
                             width: '100%',
                             dropdownParent: $('#createModal'),
                             language: {
                                 searching: function() {
                                     return "Mencari...";
                                 },
                                 inputTooShort: function() {
                                     return "Ketik untuk mencari proposal...";
                                 },
                                 noResults: function() {
                                     return "Tidak ada hasil ditemukan";
                                 }
                             }
                         });

                         // Tambahkan placeholder ke input pencarian Select2 saat dropdown terbuka
                         $('#select-proposal').on('select2:open', function() {
                             let searchField = $('.select2-search__field');
                             searchField.attr('placeholder', 'Ketik untuk mencari proposal...');
                         });

                         // Reset nilai saat modal ditutup
                         $('#createModal').on('hidden.bs.modal', function() {
                             $('#select-proposal').val(null).trigger('change');
                         });
         </script>

         <script>
             $(document).ready(function() {
                 // Select2 di modal tambah
                 $('#createModal').on('shown.bs.modal', function() {
                     $('#select-proposal').select2({
                         dropdownParent: $('#createModal'),
                         width: '100%',
                         theme: 'bootstrap4',
                         placeholder: '-- Pilih Proposal --'
                     });
                 });

                 // DataTables dengan freeze header & kolom
                 $('#tipologiTable').DataTable({
                     scrollX: true,
                     scrollY: "500px",
                     scrollCollapse: true,
                     paging: true,
                     fixedHeader: true,
                     fixedColumns: {
                         leftColumns: 2
                     },
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
                     drawCallback: function() {
                         $('.dataTables_paginate > .pagination').addClass('pagination-sm');
                     }
                 });
             });
         </script>

         <script>
             document.getElementById('add-bantuan').addEventListener('click', function() {
                 let wrapper = document.getElementById('bantuan-wrapper');
                 let newItem = document.createElement('div');
                 newItem.classList.add('bantuan-item', 'mb-3', 'd-flex', 'align-items-start', 'gap-2');
                 newItem.innerHTML = `
        <div style="flex-grow:1;">
            <label class="form-label">Jenis Bantuan</label>
            <input type="text" name="jenis_bantuan[]" class="form-control mb-2" placeholder="Contoh: Bibit Alpukat" required>

            <label class="form-label">Jumlah</label>
            <input type="text" name="jumlah_bantuan[]" class="form-control" placeholder="Contoh: 500 buah" required>
        </div>
        <button type="button" class="btn btn-danger btn-remove" style="height: fit-content; margin-top: 28px;">&times;</button>
    `;
                 wrapper.appendChild(newItem);
             });

             // Event delegation untuk tombol hapus
             document.getElementById('bantuan-wrapper').addEventListener('click', function(e) {
                 if (e.target && e.target.classList.contains('btn-remove')) {
                     e.target.closest('.bantuan-item').remove();
                 }
             });
         </script>


         {{-- EDIT MODAL --}}
         <script>
             $(document).on('click', '.btn-edit', function() {
                 const id = $(this).data('id');
                 const nama = $(this).data('nama');
                 const jabatan = $(this).data('jabatan');
                 const proposal = $(this).data('proposal');

                 // Isi field dasar
                 $('#edit-nama').val(nama);
                 $('#edit-jabatan').val(jabatan);
                 $('#edit-proposal').val(proposal);

                 // Update action form
                 $('#editForm').attr('action', '/berita-acara/' + id);

                 // Kosongkan dulu bantuan lama
                 $('#edit-bantuan-wrapper').html('');

                 // Ambil data bantuan dari server (pastikan route-nya ada)
                 $.get(`/berita-acara/${id}/bantuan`, function(data) {
                     data.forEach(function(item) {
                         let row = `
                    <div class="bantuan-item mb-3 d-flex align-items-start gap-2">
                        <div style="flex-grow:1;">
                            <label class="form-label">Jenis Bantuan</label>
                            <input type="text" name="jenis_bantuan[]" value="${item.jenis_bantuan}" class="form-control mb-2" required>

                            <label class="form-label">Jumlah</label>
                            <input type="text" name="jumlah_bantuan[]" value="${item.jumlah_bantuan}" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-remove" style="height: fit-content; margin-top: 28px;">&times;</button>
                    </div>
                `;
                         $('#edit-bantuan-wrapper').append(row);
                     });
                 });
             });

             // Tambah bantuan di modal edit
             $('#edit-add-bantuan').on('click', function() {
                 let row = `
            <div class="bantuan-item mb-3 d-flex align-items-start gap-2">
                <div style="flex-grow:1;">
                    <label class="form-label">Jenis Bantuan</label>
                    <input type="text" name="jenis_bantuan[]" class="form-control mb-2" required>

                    <label class="form-label">Jumlah</label>
                    <input type="text" name="jumlah_bantuan[]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger btn-remove" style="height: fit-content; margin-top: 28px;">&times;</button>
            </div>
        `;
                 $('#edit-bantuan-wrapper').append(row);
             });

             // Hapus field bantuan
             $(document).on('click', '.btn-remove', function() {
                 $(this).closest('.bantuan-item').remove();
             });
         </script>


         {{-- DELETE MODAL --}}
         <script>
             $(document).on('click', '.btn-delete', function() {
                 const id = $(this).data('id');
                 const nama = $(this).data('nama');

                 $('#deleteDataName').text(nama);
                 $('#deleteForm').attr('action', '/berita-acara/' + id);
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
