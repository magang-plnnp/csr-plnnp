@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
            background-color: #78C841 !important;
            border-color: #78C841 !important;
            color: white !important;
        }

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

                            <select id="filter-status" class="form-select" style="min-width: 200px;">
                                <option value="">-- Semua Status --</option>
                                @foreach ($proposals->pluck('status')->unique() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
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
                                        <h6 class="fw-semibold mb-0">Tipologi</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Nominal Disetujui</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Barang Disetujui</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">PIC</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Proses</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Keterangan</h6>
                                    </th>
                                    <th class="berkas-checklist">
                                        <h6 class="fw-semibold mb-0">Berkas</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Overdue</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Progress (%)</h6>
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
                                        $total = $subs->count();
                                        $done = count(array_intersect($subs->pluck('id')->all(), $checked));
                                        $percent = $total ? round(($done / $total) * 100) : 0;
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
                                            <p class="mb-0 fw-normal">{{ $data->tipologi->kode ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->status }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->nominal_disetujui ?? '-' }}</p>
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
                                        <td>
                                            <p class="mb-0 fw-normal">{{ $data->keterangan }}</p>
                                        </td>
                                        <td class="berkas-container">
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
                                            <p class="mb-0 fw-normal">{{ $data->overdue ?? '-' }}</p>
                                        </td>
                                        <td class="progress-col">{{ $percent }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
            let table;

            $(document).ready(function() {
                table = $('#proposalTable').DataTable({
                    scrollX: true,
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

                $('#filter-pic, #filter-tipologi, #filter-status').on('change', applyFilters);

                $('.checklist-toggle').on('change', function() {
                    let isChecked = $(this).is(':checked') ? 1 : 0;
                    let proposalId = $(this).data('proposal-id');
                    let subProsesId = $(this).data('sub-proses-id');

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
                            location.reload(); // optional: reload page to update progress
                        },
                        error: function(xhr) {
                            alert('Gagal memperbarui checklist!');
                        }
                    });
                });
            });

            function applyFilters() {
                const pic = $('#filter-pic').val().toLowerCase();
                const tipologi = $('#filter-tipologi').val().toLowerCase();
                const status = $('#filter-status').val().toLowerCase();

                table.columns(11).search(pic); // PIC
                table.columns(7).search(tipologi); // Tipologi
                table.columns(8).search(status); // Status

                table.draw();
            }
        </script>
    @endpush
@endsection
