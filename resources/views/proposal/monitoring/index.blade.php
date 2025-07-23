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
                        <table id="proposalTable" class="table table-bordered mb-0 align-middle fixed-table">
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
                                    <th class="berkas-checklist">
                                        <h6 class="fw-semibold mb-0">Berkas</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Keterangan</h6>
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

    <!-- Modal -->
    <div class="modal fade" id="keteranganModal" tabindex="-1" aria-labelledby="keteranganModalLabel" aria-hidden="true">
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
                        <button type="submit" style="background-color: #78C841; color: white;"class="btn">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
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
            let table;

            $(document).ready(function() {
                // Inisialisasi DataTable
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
                    drawCallback: function() {
                        $('.dataTables_paginate > .pagination').addClass('pagination-sm');
                    }
                });

                // Filter dropdown
                $('#filter-pic, #filter-tipologi, #filter-status').on('change', applyFilters);

                // Toggle checklist
                $('.checklist-toggle').on('change', function() {
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
                            location.reload(); // opsional
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
                $('.open-keterangan-modal').on('click', function() {
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
                            location.reload(); // atau update DOM langsung
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
                const status = $('#filter-status').val().toLowerCase();

                table.columns(11).search(pic); // Kolom PIC
                table.columns(7).search(tipologi); // Kolom Tipologi
                table.columns(8).search(status); // Kolom Status

                table.draw();
            }
        </script>
    @endpush
@endsection
