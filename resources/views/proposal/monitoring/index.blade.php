@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap5.min.css">

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
                    <h5 class="card-title fw-semibold mb-4">Monitoring Proposal</h5>
                    <div class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <select id="filter-pic" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua PIC --</option>
                                @foreach ($proposals->pluck('namaPic.nama')->unique() as $namaPic)
                                    <option value="{{ $namaPic }}">{{ $namaPic }}</option>
                                @endforeach
                            </select>

                            <select id="filter-tipologi" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua Tipologi --</option>
                                @foreach ($proposals->pluck('tipologi.kode')->unique() as $tipologi)
                                    <option value="{{ $tipologi }}">{{ $tipologi }}</option>
                                @endforeach
                            </select>

                            <select id="filter-progress" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua Progress --</option>
                                <option value="0">0%</option>
                                <option value="20">20%</option>
                                <option value="40">40%</option>
                                <option value="60">60%</option>
                                <option value="80">80%</option>
                                <option value="100">100%</option>
                            </select>

                            <select id="filter-year" class="form-select" style="min-width: 160px;">
                                <option value="">-- Semua Tahun --</option>
                                @foreach ($proposals->pluck('tanggal_disposisi')->map(fn($d) => \Carbon\Carbon::parse($d)->year)->unique()->sort() as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <a href="#" id="exportExcel" style="background-color: #78C841; color: white;" class="btn">
                            <i class="fas fa-plus me-1"></i> Export Excel
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
                                        <span class="fw-semibold mb-0">Judul</span>
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
                                    <th class="berkas-checklist">
                                        <span class="fw-semibold mb-0">Berkas</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Keterangan</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Overdue</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Progress (%)</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Berita Acara</span>
                                    </th>
                                    <th style="white-space: nowrap;" class="nowrap">
                                        <span class="fw-semibold mb-0">Kelayakan</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proposals as $index => $data)
                                    @php
                                        $subs = $data->tipeProses?->subProses ?? collect();
                                        $checked = $data->checklist
                                            ->where('is_checked', 1)
                                            ->pluck('sub_proses_id')
                                            ->all();
                                    @endphp
                                    <tr>
                                        <td>
                                            <h6 class="fw-normal mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-normal mb-0">{{ $data->judul }}</h6>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->instansi_pengajuan }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->lokasi }}</p>
                                        </td>
                                        <td data-year="{{ \Carbon\Carbon::parse($data->tanggal_disposisi)->year }}">
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($data->tanggal_disposisi)->translatedFormat('d F Y') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">
                                                {{ $data->nominal_pengajuan ? 'Rp' . number_format($data->nominal_pengajuan, 0, ',', '.') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->barang_pengajuan }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->tipologi->kode ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->status }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">
                                                {{ $data->nominal_disetujui ? 'Rp' . number_format($data->nominal_disetujui, 0, ',', '.') : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->barang_disetujui ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->namaPic->nama ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->tipeProses->nama ?? '-' }}</p>
                                        </td>
                                        <td class="berkas-container">
                                            @php
                                                // Hitung jumlah checklist sesuai progress
                                                $jumlahChecklistSesuaiProgress = floor(($data->progress ?? 0) / 20);

                                                // Ambil ID dari sub proses yang akan dicentang
                                                $subIdsToCheck = $subs
                                                    ->pluck('id')
                                                    ->take($jumlahChecklistSesuaiProgress)
                                                    ->all();
                                            @endphp

                                            @foreach ($subs as $sub)
                                                <div class="form-check">
                                                    <input class="form-check-input checklist-toggle" type="checkbox"
                                                        data-proposal-id="{{ $data->id }}"
                                                        data-sub-proses-id="{{ $sub->id }}"
                                                        {{ in_array($sub->id, $checked) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $sub->nama_sub }}</label>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal d-flex justify-content-between align-items-center">
                                                <span class="keterangan-text">{{ $data->keterangan ?: '-' }}</span>
                                                <button class="btn btn-sm btn-link text-primary open-keterangan-modal"
                                                    data-id="{{ $data->id }}"
                                                    data-keterangan="{{ $data->keterangan }}">
                                                    ✎
                                                </button>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($data->overdue)->translatedFormat('d F Y') }}
                                            </p>

                                        </td>
                                        <td class="progress-col">{{ $data->progress }}%</td>
                                        <td>
                                            @if ($data->beritaAcara && $data->beritaAcara->file_pdf)
                                                <a href="{{ asset('storage/' . $data->beritaAcara->file_pdf) }}"
                                                    target="_blank">Lihat PDF</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->kelayakan && $data->kelayakan->file_pdf)
                                                <a href="{{ asset('storage/' . $data->kelayakan->file_pdf) }}"
                                                    target="_blank">Lihat PDF</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
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

    <!-- Modal -->
    <div class="modal fade" id="keteranganModal" tabindex="-1" aria-labelledby="keteranganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="keteranganForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="keteranganModalLabel">Edit Keterangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="proposal_id" id="modalProposalId">
                        <div class="mb-3">
                            <label for="keteranganInput" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keteranganInput">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" style="background-color: #78C841; color: white;"class="btn">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

        <script>
            let table;

            $('#exportExcel').on('click', function() {
                const tipologi = $('#filter-tipologi').val(); // ambil dari filtermu
                const pic = $('#filter-pic').val(); // ambil dari filtermu
                const status = $('#filter-status').val(); // ambil dari filtermu

                let query = $.param({
                    status: status,
                    tipologi: tipologi,
                    pic: pic,
                });
                window.location.href = `/export-proposals?${query}`;
            });


            $(document).ready(function() {
                // Inisialisasi DataTable
                table = $('#proposalTable').DataTable({
                    scrollX: true,
                    scrollY: "500px", // max-height 500px
                    scrollCollapse: true,
                    paging: true,
                    fixedHeader: true, // freeze header
                    fixedColumns: {
                        leftColumns: 2 // freeze 2 kolom kiri
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

                // Toggle checklist
                // Benar: menggunakan event delegation agar bekerja untuk elemen dinamis
                $(document).on('change', '.checklist-toggle', function() {
                    const isChecked = $(this).is(':checked') ? 1 : 0;
                    const proposalId = $(this).data('proposal-id');
                    const subProsesId = $(this).data('sub-proses-id');

                    $.ajax({
                        url: "{{ route('checklist.update') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            proposal_id: proposalId,
                            sub_proses_id: subProsesId,
                            is_checked: isChecked
                        },
                        success: function(response) {
                            console.log(response.message);

                            // Ambil nilai progress dari response jika dikirimkan (lebih baik tambahkan)
                            if (response.progress !== undefined) {
                                // Update kolom progress langsung di baris yang sesuai
                                const row = $(`input[data-proposal-id="${proposalId}"]`).closest(
                                    'tr');
                                row.find('.progress-col').text(response.progress + '%');
                            }
                        },
                        error: function() {
                            alert('Gagal memperbarui checklist!');
                        }
                    });
                });



                // Inline input keterangan
                $('.keterangan-input').on('change', function() {
                    const proposalId = $(this).data('id');
                    const value = $(this).val();

                    $.ajax({
                        url: "{{ route('monitoring.keterangan') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            proposal_id: proposalId,
                            keterangan: value
                        },
                        success: function() {
                            console.log('Keterangan berhasil diperbarui');
                        },
                        error: function() {
                            alert('Gagal menyimpan keterangan');
                        }
                    });
                });

                // Buka modal titik tiga
                $(document).on('click', '.open-keterangan-modal', function() {
                    const id = $(this).data('id');
                    const keterangan = $(this).data('keterangan');

                    $('#modalProposalId').val(id);
                    $('#keteranganInput').val(keterangan);
                    $('#keteranganModal').modal('show');
                });

                // Submit form keterangan (modal)
                $('#keteranganForm').on('submit', function(e) {
                    e.preventDefault();

                    const id = $('#modalProposalId').val();
                    const keterangan = $('#keteranganInput').val();

                    $.ajax({
                        url: "{{ route('monitoring.keterangan') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            proposal_id: id,
                            keterangan: keterangan
                        },
                        success: function() {
                            $('#keteranganModal').modal('hide');
                            // Update nilai keterangan langsung di tabel
                            const row = $(`button[data-id="${id}"]`).closest('tr');
                            row.find('.keterangan-text').text(keterangan);
                            row.find('.open-keterangan-modal').data('keterangan', keterangan);

                            // Tampilkan toast
                            showToast('Keterangan berhasil diperbarui');
                        },
                        error: function() {
                            alert('Gagal menyimpan keterangan');
                        }
                    });
                });
            });

            // Filter logic
            function applyFilters() {
                const pic = $('#filter-pic').val().toLowerCase();
                const tipologi = $('#filter-tipologi').val().toLowerCase();
                const progressFilter = $('#filter-progress').val();
                const year = $('#filter-year').val();

                // Filter PIC (kolom 11)
                table.columns(11).search(pic);

                // Filter Tipologi (kolom 7)
                table.columns(7).search(tipologi);

                // Filter Progress (kolom 16)
                if (progressFilter) {
                    table.column(16).search('^' + progressFilter + '%$', true, false);
                } else {
                    table.column(16).search('', true, false);
                }

                // Filter Tahun menggunakan custom filter DataTables
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    const rowYear = $(table.row(dataIndex).node()).find('td[data-year]').data('year');

                    if (!year || rowYear == year) return true;
                    return false;
                });

                table.draw();

                // Hapus filter callback agar tidak menumpuk
                $.fn.dataTable.ext.search.pop();
            }

            // Trigger semua filter
            $('#filter-pic, #filter-tipologi, #filter-progress, #filter-year').on('change', applyFilters);
        </script>
        <script>
            function showToast(message) {
                const toastHtml = `
        <div class="position-fixed top-0 end-0 p-3 mt-5 me-5" style="z-index: 9999">
            <div class="toast align-items-center text-white border-0" role="alert"
                style="background-color: #78C841;" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>`;

                const tempContainer = document.createElement('div');
                tempContainer.innerHTML = toastHtml;
                document.body.appendChild(tempContainer);

                const toastEl = tempContainer.querySelector('.toast');
                const bsToast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                bsToast.show();

                toastEl.addEventListener('hidden.bs.toast', () => {
                    tempContainer.remove();
                });
            }
        </script>
    @endpush
@endsection
