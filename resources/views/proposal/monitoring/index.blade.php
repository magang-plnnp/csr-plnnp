@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    @endpush

    <style>
        div.dataTables_filter {
            float: left !important;
            text-align: left !important;
            margin-bottom: 20px;
        }

        div.dataTables_paginate {
            margin-top: 20px;
        }

        #usersTable tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        #usersTable tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #usersTable tbody tr:hover {
            background-color: #e0e0e0;
        }

        td.select-proses {
            min-width: 180px;
        }

        td.berkas-checklist {
            min-width: 230px;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Data Proposal</h5>
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Pengajuan Proposal</th>
                                    <th>Instansi Pengajuan</th>
                                    <th>PIC</th>
                                    <th class="select-proses">Proses</th>
                                    <th class="berkas-checklist">Berkas</th>
                                    <th>Keterangan</th>
                                    <th>Overdue</th>
                                    <th>Progress (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proposals as $index => $proposal)
                                    @php
                                        $subs = $proposal->tipeProses?->subProses ?? collect();
                                        $checked = $proposal->checklist
                                            ->where('is_checked', 1)
                                            ->pluck('sub_proses_id')
                                            ->all();
                                        $total = $subs->count();
                                        $done = count(array_intersect($subs->pluck('id')->all(), $checked));
                                        $percent = $total ? round(($done / $total) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $proposal->judul }}</td>
                                        <td>{{ $proposal->instansi_pengajuan }}</td>
                                        <td>{{ $proposal->namaPic->nama ?? '-' }}</td>
                                        <td>{{ $proposal->tipeProses->nama ?? '-' }}</td>
                                        <td class="berkas-container">
                                            @foreach ($subs as $sub)
                                                <div class="form-check">
                                                    <input class="form-check-input checklist-toggle" type="checkbox"
                                                        data-proposal-id="{{ $proposal->id }}"
                                                        data-sub-proses-id="{{ $sub->id }}"
                                                        {{ in_array($sub->id, $checked) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $sub->nama_sub }}</label>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{ $proposal->keterangan }}</td>
                                        <td>{{ $proposal->overdue }}</td>
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
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        zeroRecords: "Data tidak ditemukan",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        }
                    }
                });

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
                            location.reload(); // reload agar progress update (optional)
                        },
                        error: function(xhr) {
                            alert('Gagal memperbarui checklist!');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
