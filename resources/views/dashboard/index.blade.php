@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@stack('scripts')

@section('content')
    <div class="row">
        <!-- Kolom 1: Total Pengajuan dan Progress -->
        <div class="col-lg-4 col-md-6 mb-4 d-flex flex-column gap-2">
            <!-- Total Pengajuan -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">Total Pengajuan</h5>
                    <h4 class="fw-bold text-success">Rp{{ number_format($totalPengajuan, 0, ',', '.') }}</h4>
                </div>
            </div>


            <!-- Total Pengajuan dengan Progress Bar -->
            <div class="card flex-grow-1">
                <div class="card-body">
                    <h5 class="card-title mb-4 fw-semibold">Total Pengajuan</h5>
                    <h1 class="fw-bold display-4">{{ $jumlahPengajuan }}</h1>

                    <div class="mb-3">
                        <p class="mb-1">Setuju</p>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success fw-semibold"
                                style="width: {{ $jumlahPengajuan > 0 ? ($jumlahSetuju / $jumlahPengajuan) * 100 : 0 }}%">
                                {{ $jumlahSetuju }}

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1">Tidak Setuju</p>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-danger fw-semibold"
                                style="width: {{ $jumlahPengajuan > 0 ? ($jumlahTolak / $jumlahPengajuan) * 100 : 0 }}%">
                                {{ $jumlahTolak }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1">Pending</p>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-warning text-dark fw-semibold"
                                style="width: {{ $jumlahPengajuan > 0 ? ($jumlahPending / $jumlahPengajuan) * 100 : 0 }}%">
                                {{ $jumlahPending }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- Kolom 2: Nominal Disetujui dan Pie Chart -->
        <div class="col-lg-4 col-md-6 mb-4 d-flex flex-column gap-2">
            <!-- Nominal Disetujui -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">Nominal Disetujui</h5>
                    <h4 class="fw-bold text-success">Rp{{ number_format($totalDisetujui ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Pie Chart Jumlah -->
            <div class="card flex-grow-1">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Jumlah Proposal per Tipologi</h5>
                    <div id="pieChartContainer" style="height: 250px;">
                        <canvas id="jumlahPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom 3: Rincian Nominal Disetujui -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-95">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Rincian Nominal Disetujui</h5>
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Kategori</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rincianDisetujui as $item)
                                <tr>
                                    <td>{{ $item->kategori }}</td>
                                    <td class="text-end">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data disetujui</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel PIC -->
    <div class="card">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th colspan="{{ 2 + count($tipologiList) * 2 }}">PIC</th>
                        </tr>
                        <tr class="bg-light text-dark">
                            <th>Nama</th>
                            <th>Total</th>
                            @foreach ($tipologiList as $kode)
                                <th>{{ $kode }}</th>
                            @endforeach
                            @foreach ($tipologiList as $kode)
                                <th>{{ $kode }} (%)</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($picTable as $row)
                            <tr>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['total'] }}</td>
                                @foreach ($tipologiList as $kode)
                                    <td>{{ $row['jumlah'][$kode] ?? 0 }}</td>
                                @endforeach
                                @foreach ($tipologiList as $kode)
                                    <td>{{ $row['persen'][$kode] ?? 0 }}%</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="fw-bold bg-light">
                            <td>Total</td>
                            <td>{{ collect($picTable)->sum('total') }}</td>
                            @foreach ($tipologiList as $kode)
                                <td>{{ collect($picTable)->sum(fn($r) => $r['jumlah'][$kode] ?? 0) }}</td>
                            @endforeach
                            <td colspan="{{ count($tipologiList) }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('jumlahPieChart').getContext('2d');

        // Labels = Kode tipologi
        const pieLabels = {!! json_encode(array_values($tipologiList)) !!};

        // Data = Total proposal per tipologi
        const pieData = {!! json_encode(
            array_map(function ($id) use ($totalPerTipologi) {
                return $totalPerTipologi[$id] ?? 0;
            }, array_keys($tipologiList)),
        ) !!};

        const pieColors = ['#ff9800', '#2196f3', '#f44336', '#ffeb3b', '#4caf50', '#9c27b0', '#00bcd4'];

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: pieColors.slice(0, pieLabels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#333'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
