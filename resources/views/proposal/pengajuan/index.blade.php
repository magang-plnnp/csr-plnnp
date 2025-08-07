@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Freeze Header */
        table.dataTable thead th {
            position: sticky;
            top: 0;
            background-color: white !important;
            z-index: 10;
        }

        /* Freeze Kolom "No" (kolom pertama) dan "Judul" (kolom kedua) */
        table.dataTable tbody td:first-child,
        table.dataTable thead th:first-child {
            position: sticky;
            left: 0;
            background-color: white !important;
            z-index: 11;
        }

        table.dataTable tbody td:nth-child(2),
        table.dataTable thead th:nth-child(2) {
            position: sticky;
            left: 60px;
            /* Sesuaikan dengan lebar kolom pertama */
            background-color: white !important;
            z-index: 11;
        }

        /* CSS untuk mengatasi masalah transparansi pada Fixed Columns */

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

        /* Wrapper untuk DataTable */
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }

        /* table.dataTable td p,
                                                        table.dataTable td span,
                                                        table.dataTable th h6 {
                                                            white-space: nowrap !important;
                                                        } */

        table.dataTable,
        table.dataTable th,
        table.dataTable td,
        table.dataTable td>*,
        table.dataTable th>* {
            white-space: normal !important;
        }

        .text-wrap,
        .text-break {
            white-space: normal !important;
        }

        /* NO-WRAP semua elemen di tabel #proposalTable */
        #proposalTable * {
            white-space: normal !important;
            word-break: keep-all !important;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Paksa semua elemen dalam tabel untuk nowrap
                                                        #proposalTable,
                                                        #proposalTable th,
                                                        #proposalTable td,
                                                        #proposalTable th *,
                                                        #proposalTable td * {
                                                            white-space: nowrap !important;
                                                        } */

        /* Hindari teks meluber */
        #proposalTable td {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Supaya bisa scroll horizontal */
        .table-responsive {
            overflow-x: auto;
        }

        /* SOLUSI UTAMA: Fixed Columns styling */
        /* Background untuk kolom yang di-freeze - SELALU SOLID */
        .DTFC_LeftWrapper table.dataTable thead th {
            background-color: #f8f9fa !important;
            /* Background header yang solid */
            position: relative;
            z-index: 10 !important;
            border-right: 1px solid #dee2e6 !important;
        }

        .DTFC_LeftWrapper table.dataTable tbody td {
            background-color: #ffffff !important;
            /* Background sel yang SELALU solid */
            position: relative;
            z-index: 10 !important;
            border-right: 1px solid #dee2e6 !important;
        }

        /* Wrapper untuk kolom kiri - SELALU SOLID */
        .DTFC_LeftWrapper {
            background-color: #ffffff !important;
            z-index: 5 !important;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15) !important;
            border-right: 2px solid #dee2e6 !important;
        }

        /* PENTING: Override hover effect agar tetap solid */
        .DTFC_LeftWrapper table.dataTable tbody tr:hover td {
            background-color: #f1f3f4 !important;
            /* Warna hover yang tetap solid */
        }

        /* Hover effect untuk tabel utama (non-freeze) */
        table.dataTable tbody tr:hover {
            background-color: transparent !important;
        }

        table.dataTable tbody tr:hover td:not(.DTFC_LeftWrapper td) {
            background-color: #f8f9fa !important;
        }

        /* Pastikan header di kolom freeze SELALU solid */
        .DTFC_LeftWrapper table.dataTable thead th {
            background-color: #f8f9fa !important;
            font-weight: 600 !important;
            border-bottom: 2px solid #dee2e6 !important;
        }

        /* Styling khusus untuk kolom yang tidak di-freeze */
        .DTFC_ScrollWrapper table.dataTable {
            margin-left: 0 !important;
        }

        /* Pastikan tidak ada overlap yang aneh */
        .DTFC_LeftWrapper table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        /* Styling untuk border yang konsisten */
        .DTFC_LeftWrapper table.dataTable td,
        .DTFC_LeftWrapper table.dataTable th {
            border-left: 1px solid #dee2e6 !important;
        }

        /* Border untuk kolom pertama */
        .DTFC_LeftWrapper table.dataTable td:first-child,
        .DTFC_LeftWrapper table.dataTable th:first-child {
            border-left: 1px solid #dee2e6 !important;
        }

        /* Menghilangkan double border */
        .DTFC_ScrollWrapper table.dataTable td:first-child,
        .DTFC_ScrollWrapper table.dataTable th:first-child {
            border-left: none !important;
        }

        /* FORCE SOLID BACKGROUND - Tambahkan di paling bawah */
        .DTFC_LeftWrapper .table td,
        .DTFC_LeftWrapper .table th {
            background-color: #fff !important;
            background: #fff !important;
        }

        .DTFC_LeftWrapper .table tbody tr td {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        .DTFC_LeftWrapper .table thead tr th {
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
        }

        /* Override semua kemungkinan hover dan stripe */
        .DTFC_LeftWrapper .table-striped tbody tr:nth-of-type(odd) td,
        .DTFC_LeftWrapper .table tbody tr:hover td,
        .DTFC_LeftWrapper .table tbody tr.selected td {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        .DTFC_LeftWrapper .table tbody tr:hover td {
            background-color: #f1f3f4 !important;
            background: #f1f3f4 !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Data Proposal</h5>
                    <div class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <select id="filter-pic" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua PIC --</option>
                                @foreach ($proposal->pluck('namaPic.nama')->unique() as $namaPic)
                                    <option value="{{ $namaPic }}">{{ $namaPic }}</option>
                                @endforeach
                            </select>

                            <select id="filter-tipologi" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua Tipologi --</option>
                                @foreach ($proposal->pluck('tipologi.kode')->unique() as $tipologi)
                                    <option value="{{ $tipologi }}">{{ $tipologi }}</option>
                                @endforeach
                            </select>

                            <select id="filter-progress" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua Progress --</option>
                                <option value="20">20%</option>
                                <option value="40">40%</option>
                                <option value="60">60%</option>
                                <option value="80">80%</option>
                                <option value="100">100%</option>
                            </select>
                        </div>


                        <a href="/proposal/create" style="background-color: #78C841; color: white;" class="btn ">
                            <i class="fas fa-plus me-1"></i> Tambah Proposal
                        </a>
                    </div>


                    <div class="table-responsive">
                        <table id="proposalTable" class="table table-bordered nowrap" style="width: 100%">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">No</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold">Judul</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Instansi</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Lokasi</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Tanggal</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Nominal Pengajuan</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Barang Pengajuan</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Tipologi</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Status</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Nominal Disetujui</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Barang Disetujui</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">PIC</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Proses</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Keterangan</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Overdue</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Progress</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Berita Acara</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Kelayakan</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proposal as $data)
                                    <tr>
                                        <td><span class="fw-normal">{{ $loop->iteration }}</span></td>
                                        <td><span class="fw-normal">{{ $data->judul }}</span></td>
                                        <td><span class="fw-normal">{{ $data->instansi_pengajuan }}</span></td>
                                        <td><span
                                                class="fw-normal">{{ $data->kabupaten_nama }}-{{ $data->kecamatan_nama }}-{{ $data->kelurahan_nama }}</span>
                                        </td>
                                        <td><span
                                                class="fw-normal">{{ \Carbon\Carbon::parse($data->tanggal_disposisi)->translatedFormat('d F Y') }}</span>
                                        </td>
                                        <td><span
                                                class="fw-normal">{{ $data->nominal_pengajuan ? 'Rp' . number_format($data->nominal_pengajuan, 0, ',', '.') : '-' }}</span>
                                        </td>
                                        <td><span class="fw-normal">{{ $data->barang_pengajuan }}</span></td>
                                        <td><span class="fw-normal">{{ $data->tipologi->kode }}</span></td>
                                        <td><span class="fw-normal">{{ $data->status }}</span></td>
                                        <td><span
                                                class="fw-normal">{{ $data->nominal_disetujui ? 'Rp' . number_format($data->nominal_disetujui, 0, ',', '.') : '-' }}</span>
                                        </td>
                                        <td><span class="fw-normal">{{ $data->barang_disetujui ?? '-' }}</span></td>
                                        <td><span class="fw-normal">{{ $data->namaPic->nama ?? '-' }}</span></td>
                                        <td><span class="fw-normal">{{ $data->tipeProses->nama ?? '-' }}</span></td>
                                        <td><span class="fw-normal">{{ $data->keterangan }}</span></td>
                                        <td><span
                                                class="fw-normal">{{ \Carbon\Carbon::parse($data->overdue)->translatedFormat('d F Y') }}</span>
                                        </td>
                                        <td><span class="fw-normal">{{ $data->progress }}</span></td>
                                        <td><span class="fw-normal">
                                                @if ($data->beritaAcara && $data->beritaAcara->file_pdf)
                                                    <a href="{{ asset('storage/' . $data->beritaAcara->file_pdf) }}"
                                                        target="_blank">Lihat PDF</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td><span class="fw-normal">
                                                @if ($data->kelayakan && $data->kelayakan->file_pdf)
                                                    <a href="{{ asset('storage/' . $data->kelayakan->file_pdf) }}"
                                                        target="_blank">Lihat PDF</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border-0" type="button"
                                                    id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                                    <li>
                                                        <a href="{{ route('proposal.edit', $data->id) }}"
                                                            class="dropdown-item text-primary">Edit</a>
                                                    </li>
                                                    <button type="button" class="dropdown-item text-danger btn-delete"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="{{ $data->id }}" data-nama="{{ $data->judul }}">
                                                        Hapus
                                                    </button>
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
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script>
            function applyFilters() {
                const pic = $('#filter-pic').val().toLowerCase();
                const tipologi = $('#filter-tipologi').val().toLowerCase();
                const progressFilter = $('#filter-progress').val();

                const table = $('#proposalTable').DataTable();

                table.columns(11).search(pic);
                table.columns(7).search(tipologi);

                if (progressFilter) {
                    table.column(15).search('^' + progressFilter + '$', true, false);
                } else {
                    table.column(15).search('', true, false);
                }

                table.draw();
            }
            $('#filter-pic, #filter-tipologi, #filter-progress').on('change', applyFilters);
            // Tambahkan script ini setelah inisialisasi DataTable
            function forceFixedColumnsBackground() {
                // Target semua elemen dengan position sticky
                $('th[style*="position: sticky"], td[style*="position: sticky"]').each(function() {
                    // Force background menggunakan inline style
                    this.style.setProperty('background-color', '#ffffff', 'important');
                    this.style.setProperty('background', '#ffffff', 'important');
                    this.style.setProperty('box-shadow', '2px 0 5px rgba(0, 0, 0, 0.1)', 'important');
                });

                // Khusus untuk header
                $('thead th[style*="position: sticky"]').each(function() {
                    this.style.setProperty('background-color', '#f8f9fa', 'important');
                    this.style.setProperty('background', '#f8f9fa', 'important');
                });

                // Target juga berdasarkan class jika ada
                $('.dtfc-fixed-left, .dt-column-left').each(function() {
                    this.style.setProperty('background-color', '#ffffff', 'important');
                    this.style.setProperty('background', '#ffffff', 'important');
                });

                $('.dtfc-fixed-left.dt-head, .dt-column-left.dt-head, thead .dtfc-fixed-left, thead .dt-column-left').each(
                    function() {
                        this.style.setProperty('background-color', '#f8f9fa', 'important');
                        this.style.setProperty('background', '#f8f9fa', 'important');
                    });
            }

            // Jalankan setelah DataTable diinisialisasi
            $('#proposalTable').on('init.dt', function() {
                setTimeout(forceFixedColumnsBackground, 100);
            });

            // Jalankan setiap kali tabel di-redraw
            $('#proposalTable').on('draw.dt', function() {
                setTimeout(forceFixedColumnsBackground, 50);
            });

            // Jalankan saat scroll
            $('.dataTables_scrollBody').on('scroll', function() {
                forceFixedColumnsBackground();
            });

            // Jalankan saat hover untuk mempertahankan background
            $(document).on('mouseenter', 'tbody tr', function() {
                $(this).find('td[style*="position: sticky"], .dtfc-fixed-left, .dt-column-left').each(function() {
                    this.style.setProperty('background-color', '#f1f3f4', 'important');
                });
            });

            $(document).on('mouseleave', 'tbody tr', function() {
                $(this).find('td[style*="position: sticky"], .dtfc-fixed-left, .dt-column-left').each(function() {
                    this.style.setProperty('background-color', '#ffffff', 'important');
                });
            });

            // Jalankan sekali saat document ready
            $(document).ready(function() {
                setTimeout(function() {
                    forceFixedColumnsBackground();
                    // Jalankan lagi setelah 1 detik untuk memastikan
                    setTimeout(forceFixedColumnsBackground, 1000);
                }, 500);
            });
        </script>
        <script>
            $('#proposalTable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    leftColumns: 2 // Kolom ke-1 (No) dan ke-2 (Judul) dibekukan
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
                drawCallback: function(settings) {
                    $('.dataTables_paginate > .pagination').addClass('pagination-sm');
                }
            });
        </script>



        {{-- DELETE MODAL --}}
        <script>
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                $('#deleteDataName').text("Judul: " + nama);
                $('#deleteForm').attr('action', '/proposal/' + id);
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
