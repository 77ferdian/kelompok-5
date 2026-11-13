@extends('layouts.app')

@section('title', 'Statistik & Grafik Perkembangan - Sistem Booking Kendaraan')

@section('content')

{{-- HERO --}}
<div class="page-hero" style="padding: 24px 0 44px;">
    <div class="container-lg d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <p class="hero-sub mb-1">
                <i class="bi bi-graph-up-arrow me-1"></i> Business Analytics & Performance
            </p>
            <h1 class="hero-title mb-0" style="font-size: 1.6rem;">
                <i class="bi bi-bar-chart-line-fill me-2"></i>Grafik Perkembangan Bisnis
            </h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('bookings.index') }}" class="btn btn-light btn-sm" style="border-radius:9px; font-weight:600;">
                <i class="bi bi-table me-1"></i> Tabel Booking
            </a>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm" style="border-radius:9px; font-weight:600; background:#3b82f6; border:none;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Booking
            </a>
        </div>
    </div>
</div>

<div class="main-content" style="margin-top: -24px; padding-bottom: 50px;">
    <div class="container-lg">

        {{-- KPI METRICS ROW --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="bi bi-receipt"></i></div>
                    <div>
                        <div class="stat-label">Total Transaksi</div>
                        <div class="stat-value">{{ $totalBookings }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-check2-all"></i></div>
                    <div>
                        <div class="stat-label">Completion Rate</div>
                        <div class="stat-value">{{ $completionRate }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-label">Rata-rata Durasi</div>
                        <div class="stat-value">{{ $avgLamaSewa }} <span style="font-size:0.9rem;font-weight:500;">Hari</span></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="bi bi-calendar3-range"></i></div>
                    <div>
                        <div class="stat-label">Total Hari Sewa</div>
                        <div class="stat-value">{{ $totalHariSewa }} <span style="font-size:0.9rem;font-weight:500;">Hari</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS ROW 1: TREN WAKTU & TOP KENDARAAN --}}
        <div class="row g-4 mb-4">
            {{-- Tren Booking Bulanan --}}
            <div class="col-lg-8">
                <div class="table-card p-3 p-md-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1" style="font-size:1.05rem;">
                                <i class="bi bi-activity text-primary me-2"></i>Tren Pemesanan Sewa (6 Bulan Terakhir)
                            </h5>
                            <small class="text-muted">Aktivitas volume penyewaan kendaraan per bulan</small>
                        </div>
                    </div>
                    <div style="position: relative; height: 280px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Top 5 Kendaraan Terpopuler --}}
            <div class="col-lg-4">
                <div class="table-card p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1" style="font-size:1.05rem;">
                            <i class="bi bi-trophy-fill text-warning me-2"></i>Top Unit Terfavorit
                        </h5>
                        <small class="text-muted">Kendaraan yang paling sering disewa</small>
                    </div>
                    <div style="position: relative; height: 280px;">
                        <canvas id="topVehicleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS ROW 2: KOMPOSISI KENDARAAN & STATUS --}}
        <div class="row g-4">
            {{-- Mobil vs Motor --}}
            <div class="col-md-6">
                <div class="table-card p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1" style="font-size:1.05rem;">
                            <i class="bi bi-pie-chart-fill text-info me-2"></i>Pangsa Kendaraan (Mobil vs Motor)
                        </h5>
                        <small class="text-muted">Perbandingan pangsa pasar unit roda 4 vs roda 2</small>
                    </div>
                    <div style="position: relative; height: 260px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Distribusi Status Booking --}}
            <div class="col-md-6">
                <div class="table-card p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1" style="font-size:1.05rem;">
                            <i class="bi bi-funnel-fill text-success me-2"></i>Distribusi Status Booking
                        </h5>
                        <small class="text-muted">Status transaksi dalam alur operasional</small>
                    </div>
                    <div style="position: relative; height: 260px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
{{-- Load Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Global Chart Defaults
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = "#64748b";

        // 1. Line Chart: Tren Bulanan
        const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        const gradient = trendCtx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(49, 94, 232, 0.35)');
        gradient.addColorStop(1, 'rgba(49, 94, 232, 0.0)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrend['labels']) !!},
                datasets: [{
                    label: 'Jumlah Booking',
                    data: {!! json_encode($monthlyTrend['data']) !!},
                    borderColor: '#315ee8',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#315ee8',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Horizontal Bar: Top Kendaraan
        const topLabels = {!! json_encode($topVehicles->pluck('nama_kendaraan')) !!};
        const topData = {!! json_encode($topVehicles->pluck('total')) !!};
        new Chart(document.getElementById('topVehicleChart'), {
            type: 'bar',
            data: {
                labels: topLabels.length > 0 ? topLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Total Sewa',
                    data: topData.length > 0 ? topData : [0],
                    backgroundColor: '#f59e0b',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    y: { grid: { display: false } }
                }
            }
        });

        // 3. Doughnut: Mobil vs Motor
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Mobil', 'Motor'],
                datasets: [{
                    data: [{{ $jenisCounts['mobil'] }}, {{ $jenisCounts['motor'] }}],
                    backgroundColor: ['#3b82f6', '#10b981'],
                    hoverOffset: 4,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '68%'
            }
        });

        // 4. Bar / Doughnut: Distribusi Status
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: ['Menunggu', 'Disetujui', 'Selesai', 'Batal'],
                datasets: [{
                    label: 'Status Pesanan',
                    data: [
                        {{ $statusCounts['menunggu'] }},
                        {{ $statusCounts['disetujui'] }},
                        {{ $statusCounts['selesai'] }},
                        {{ $statusCounts['batal'] }}
                    ],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
