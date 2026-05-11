@extends('layouts.app')

@section('title', 'Dashboard - LootHub')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<style>
    :root {
        --pink:        #ff2d8d;
        --pink-dim:    rgba(255,45,141,0.08);
        --pink-border: rgba(255,45,141,0.2);
        --pink-glow:   rgba(255,45,141,0.25);
        --green:       #00d78f;
        --green-dim:   rgba(0,215,143,0.08);
        --green-border:rgba(0,215,143,0.25);
        --ink:         #111118;
        --mid:         #4a4a60;
        --muted:       #9494aa;
        --line:        #ebebf2;
        --bg:          #ffffff;
        --bg-soft:     #f8f8fc;
        --danger:      #ff4d4d;
    }

    * { box-sizing: border-box; }

    body {
        background: var(--bg) !important;
        font-family: 'Syne', sans-serif;
        color: var(--ink);
    }

    /* ── WRAPPER ── */
    .db {
        max-width: 1360px;
        margin: 0 auto;
        padding: 40px 36px 80px;
    }

    /* ── HEADER ── */
    .db-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 40px;
        padding-bottom: 28px;
        border-bottom: 1.5px solid var(--line);
        position: relative;
    }

    .db-header::after {
        content: '';
        position: absolute;
        bottom: -1.5px; left: 0;
        width: 56px; height: 2.5px;
        background: var(--pink);
        border-radius: 2px;
    }

    .db-eyebrow {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3.5px;
        text-transform: uppercase;
        color: var(--pink);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .db-eyebrow::before {
        content: '';
        width: 22px; height: 2px;
        background: var(--pink);
        border-radius: 1px;
        display: inline-block;
    }

    .db-title {
        font-size: clamp(26px, 4vw, 40px);
        font-weight: 700;
        color: var(--ink);
        line-height: 1.05;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .db-title span { color: var(--pink); }

    .db-subtitle {
        font-size: 14px;
        font-weight: 400;
        color: var(--muted);
        margin-top: 6px;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--pink);
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
        box-shadow: 0 6px 16px var(--pink-glow);
    }

    .btn-add:hover {
        background: #e6007a;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px var(--pink-glow);
        color: white;
    }

    /* ── STAT CARDS ── */
    .db-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--bg);
        border: 1.5px solid var(--line);
        border-radius: 16px;
        padding: 24px 24px 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.07);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }

    .stat-card.green::before  { background: var(--green); }
    .stat-card.pink::before   { background: var(--pink); }
    .stat-card.blue::before   { background: #4f8ef7; }
    .stat-card.amber::before  { background: #f59e0b; }

    .stat-card:hover { border-color: rgba(0,0,0,0.1); }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
        font-size: 20px;
    }

    .stat-icon.green  { background: var(--green-dim); color: var(--green); }
    .stat-icon.pink   { background: var(--pink-dim);  color: var(--pink);  }
    .stat-icon.blue   { background: rgba(79,142,247,0.08); color: #4f8ef7; }
    .stat-icon.amber  { background: rgba(245,158,11,0.08); color: #f59e0b; }
    .stat-icon i      { font-size: 20px; }

    .stat-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .stat-value.green { color: var(--green); }
    .stat-value.pink  { color: var(--pink);  }

    .stat-sub {
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
        margin-top: 6px;
    }

    /* ── SECTION LABEL ── */
    .db-section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .db-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--line);
    }

    /* ── MAIN GRID ── */
    .db-main {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* ── PANEL (shared card style) ── */
    .db-panel {
        background: var(--bg);
        border: 1.5px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .panel-head {
        padding: 18px 22px;
        border-bottom: 1.5px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .panel-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .panel-title-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .panel-title-dot.pink  { background: var(--pink); box-shadow: 0 0 6px var(--pink-glow); }
    .panel-title-dot.green { background: var(--green); }
    .panel-title-dot.red   { background: var(--danger); }

    .panel-badge {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 6px;
    }

    .panel-badge.pink  { background: var(--pink-dim);  color: var(--pink);  border: 1px solid var(--pink-border); }
    .panel-badge.green { background: var(--green-dim); color: var(--green); border: 1px solid var(--green-border);}

    .panel-body {
        padding: 22px;
        flex: 1;
    }

    /* ── CHART ── */
    .chart-wrap {
        position: relative;
        height: 240px;
    }

    /* ── TABLE ── */
    .db-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .db-table thead tr {
        border-bottom: 1.5px solid var(--line);
    }

    .db-table th {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        padding: 0 0 12px;
        text-align: left;
    }

    .db-table th:last-child { text-align: center; }

    .db-table td {
        padding: 13px 0;
        border-bottom: 1px solid var(--line);
        color: var(--ink);
        font-weight: 500;
    }

    .db-table tr:last-child td { border-bottom: none; }

    .db-table td:last-child { text-align: center; }

    .sold-badge {
        display: inline-block;
        background: var(--pink-dim);
        color: var(--pink);
        border: 1px solid var(--pink-border);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        letter-spacing: 0.5px;
    }

    /* rank number */
    .db-table .rank {
        font-size: 11px;
        font-weight: 800;
        color: var(--muted);
        margin-right: 10px;
    }

    /* ── LOW STOCK LIST ── */
    .low-stock-list {
        list-style: none;
        padding: 0; margin: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .low-stock-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid var(--line);
    }

    .low-stock-item:last-child { border-bottom: none; }

    .low-stock-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-right: 12px;
    }

    .stock-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .stock-pill.danger  { background: rgba(255,77,77,0.1); color: var(--danger); border: 1px solid rgba(255,77,77,0.2); }
    .stock-pill.warning { background: rgba(245,158,11,0.1); color: #d97706;       border: 1px solid rgba(245,158,11,0.2); }

    /* ── BOTTOM ROW ── */
    .db-bottom {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* ── EMPTY STATE ── */
    .db-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
        color: var(--muted);
        font-size: 13px;
        gap: 10px;
    }

    .db-empty-icon {
        width: 44px; height: 44px;
        background: rgba(0,215,143,0.08);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--green);
        font-size: 22px;
    }

    .btn-add i { font-size: 15px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
        .db-main { grid-template-columns: 1fr; }
        .db-bottom { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .db { padding: 20px 14px 60px; }
        .db-header { flex-direction: column; align-items: flex-start; }
        .db-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-value { font-size: 20px; }
    }
</style>

<div class="db">

    {{-- ── HEADER ── --}}
    <div class="db-header">
        <div>
            <div class="db-eyebrow">Admin Panel</div>
            <h1 class="db-title">
                Halo, <span>{{ Auth::user()->name ?? 'Admin' }}</span>!
            </h1>
            <p class="db-subtitle">Pantau performa LootHub hari ini.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn-add">
            <i class="bi bi-folder-plus"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="db-section-label">Statistik Toko</div>
    <div class="db-stats">

        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="bi bi-wallet"></i>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value green">Rp {{ number_format($totalRevenue) }}</div>
            <div class="stat-sub">Semua waktu</div>
        </div>

        <div class="stat-card pink">
            <div class="stat-icon pink">
                <i class="bi bi-cart-fill"></i>
            </div>
            <div class="stat-label">Transaksi Hari Ini</div>
            <div class="stat-value pink">{{ $todayTransactions }}</div>
            <div class="stat-sub">Pesanan masuk</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="bi bi-box2-fill"></i>
            </div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-value" style="color:#4f8ef7">{{ $totalProducts ?? '—' }}</div>
            <div class="stat-sub">Aktif di toko</div>
        </div>


    </div>

    {{-- ── CHART + LOW STOCK ── --}}
    <div class="db-section-label">Analitik</div>
    <div class="db-main">

        {{-- Revenue Chart --}}
        <div class="db-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="panel-title-dot pink"></span>
                    Pendapatan 7 Hari Terakhir
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-wrap">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="db-panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="panel-title-dot red"></span>
                    Stok Menipis
                </div>
                <span class="panel-badge" style="background:rgba(255,77,77,0.08);color:var(--danger);border:1px solid rgba(255,77,77,0.2);">
                    Perhatian
                </span>
            </div>
            <div class="panel-body" style="padding-top:8px;">
                @if($lowStockProducts->isEmpty())
                    <div class="db-empty">
                        <div class="db-empty-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        Semua stok aman
                    </div>
                @else
                    <ul class="low-stock-list">
                        @foreach($lowStockProducts as $p)
                        <li class="low-stock-item">
                            <span class="low-stock-name">{{ $p->name }}</span>
                            <span class="stock-pill {{ $p->stock <= 3 ? 'danger' : 'warning' }}">
                                {{ $p->stock }} stok
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    </div>

    {{-- ── BEST SELLER ── --}}
    <div class="db-section-label">Produk</div>
    <div class="db-panel" style="margin-bottom:0;">
        <div class="panel-head">
            <div class="panel-title">
                <span class="panel-title-dot green"></span>
                Best Seller Produk
            </div>
            <span class="panel-badge green">Top Loot</span>
        </div>
        <div class="panel-body">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Unit Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $i => $item)
                    <tr>
                        <td>
                            <span class="rank">#{{ $i + 1 }}</span>
                            {{ $item->product->name ?? 'Produk Telah Dihapus' }}
                        </td>
                        <td>
                            <span class="sold-badge">{{ $item->total_qty }} Unit</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" style="text-align:center;padding:32px 0;color:var(--muted);font-size:13px;">
                            Belum ada data penjualan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
(function () {
    // Pastikan data diparsing sebagai JSON yang valid
    const labels = {!! json_encode($revenueLabels) !!};
    const data   = {!! json_encode($revenueData) !!};

    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Cek di console browser (F12) apakah data masuk atau tidak
    console.log("Labels:", labels);
    console.log("Data:", data);

    const grad = ctx.createLinearGradient(0, 0, 0, 240);
    grad.addColorStop(0,   'rgba(255,45,141,0.18)');
    grad.addColorStop(1,   'rgba(255,45,141,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, // Gunakan variabel labels
            datasets: [{
                label: 'Pendapatan',
                data: data,   // Gunakan variabel data
                borderColor:     '#ff2d8d',
                borderWidth:     2.5,
                backgroundColor: grad,
                pointBackgroundColor: '#ff2d8d',
                pointBorderColor:    '#fff',
                pointBorderWidth:    2,
                pointRadius:         5,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9494aa', font: { family: 'Syne', size: 11, weight: '600' } }
                },
                y: {
                    beginAtZero: true, // WAJIB: Agar chart tidak mulai dari angka aneh
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        color: '#9494aa',
                        font: { family: 'Syne', size: 11 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return 'Rp ' + (value/1000) + 'rb';
                            return 'Rp ' + value;
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
})();
</script>

@endsection
