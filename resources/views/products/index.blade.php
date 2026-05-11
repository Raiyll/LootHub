@extends('layouts.app')

@section('title', 'Stok Gaming Gear - LootHub Premium')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    body, .lh-wrap { font-family: 'DM Sans', sans-serif; }

    /* ─── Top Bar ─── */
    .lh-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 0.5px solid rgba(0, 0, 0, 0.08);
    }
    .lh-brand {
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        color: #9ca3af;
        text-transform: uppercase;
    }
    .lh-user { display: flex; align-items: center; gap: 10px; }
    .lh-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #111827;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 500;
    }
    .lh-username { font-size: 13px; font-weight: 500; color: #111827; }

    /* ─── Page Header ─── */
    .lh-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; }
    .lh-title {
        font-family: 'Syne', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px;
    }
    .lh-subtitle { font-size: 13px; color: #6b7280; margin: 0; }

    /* ─── Add Button ─── */
    .btn-new {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #111827;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        text-decoration: none;
    }
    .btn-new:hover { background: #000; transform: translateY(-1px); color: #fff; }

    /* ─── Table Card ─── */
    .lh-table-wrap {
        background: #fff;
        border: 0.5px solid rgba(0, 0, 0, 0.08);
        border-radius: 14px;
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }

    thead tr { border-bottom: 0.5px solid rgba(0, 0, 0, 0.08); }
    thead th {
        padding: 14px 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
        color: #9ca3af;
        text-align: left;
        font-family: 'Syne', sans-serif;
    }
    thead th.text-center { text-align: center; }

    tbody tr {
        border-bottom: 0.5px solid rgba(0, 0, 0, 0.06);
        transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafafa; }
    tbody td { padding: 16px 20px; vertical-align: middle; }

    /* ─── Cell Styles ─── */
    .product-name { font-weight: 500; font-size: 14px; color: #111827; }
    .product-sku  { font-size: 11px; color: #9ca3af; margin-top: 2px; letter-spacing: 0.5px; }

    .cat-pill {
        display: inline-block;
        padding: 4px 12px;
        background: #f3f4f6;
        border: 0.5px solid rgba(0,0,0,0.07);
        border-radius: 100px;
        font-size: 12px;
        color: #6b7280;
        font-weight: 400;
    }

    .price { font-size: 14px; font-weight: 500; color: #111827; }

    .status-wrap { display: flex; flex-direction: column; gap: 5px; }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 11px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 500;
        width: fit-content;
    }
    .status-pill.active   { background: #d1fae5; color: #065f46; }
    .status-pill.archived { background: #f3f4f6; color: #6b7280; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .status-dot.active   { background: #059669; }
    .status-dot.archived { background: #9ca3af; }
    .stock-sub {
        font-size: 11px;
        color: #9ca3af;
        padding-left: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ─── Action Buttons ─── */
    .action-group { display: flex; align-items: center; gap: 6px; justify-content: center; }
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 0.5px solid rgba(0,0,0,0.1);
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s;
        position: relative;
        text-decoration: none;
    }
    .btn-icon svg { width: 14px; height: 14px; }
    .btn-icon:hover { border-color: rgba(0,0,0,0.18); transform: translateY(-1px); }

    .btn-icon.edit  svg { stroke: #b45309; }
    .btn-icon.edit:hover  { background: #fef3c7; border-color: #fde68a; }

    .btn-icon.del   svg { stroke: #b91c1c; }
    .btn-icon.del:hover   { background: #fee2e2; border-color: #fecaca; }

    .btn-icon.restore svg { stroke: #1d4ed8; }
    .btn-icon.restore:hover { background: #dbeafe; border-color: #bfdbfe; }

    /* Tooltip */
    .btn-icon .tip {
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        background: #111827;
        color: #fff;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-icon:hover .tip { opacity: 1; }

    /* ─── Footer ─── */
    .lh-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .lh-count  { font-size: 12px; color: #9ca3af; }
</style>
@endpush

@section('content')
<div class="lh-wrap">

    {{-- Top Bar --}}
    <div class="lh-topbar">
        <span class="lh-brand">Gudang LootHub</span>
        <div class="lh-user">
            <span class="lh-username">{{ Auth::user()->name ?? 'Admin LootHub' }}</span>
            <div class="lh-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </div>

    {{-- Page Header --}}
    <div class="lh-header">
        <div>
            <h2 class="lh-title">Stok Produk</h2>
            <p class="lh-subtitle">{{ count($products) }} item tersedia di gudang</p>
        </div>
       <a href="{{ route('products.create') }}" class="btn-new">
    <i class="bi bi-plus-circle-fill"></i>
    Produk Baru
</a>
    </div>

    {{-- Table --}}
    <div class="lh-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ITEM NAME</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>STATUS</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-sku">SKU-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>

                    <td>
                        <span class="cat-pill">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </td>

                    <td>
                        <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </td>

                    <td>
                        <div class="status-wrap">
                            @if($product->trashed())
                                <span class="status-pill archived">
                                    <span class="status-dot archived"></span>
                                    Diarsipkan
                                </span>
                            @else
                                <span class="status-pill active">
                                    <span class="status-dot active"></span>
                                    Aktif
                                </span>
                                <span class="stock-sub">
                                    <svg width="11" height="11" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                        <rect x="2" y="7" width="12" height="8" rx="1"/>
                                        <path d="M5 7V5a3 3 0 016 0v2"/>
                                    </svg>
                                    {{ $product->stock }} unit
                                </span>
                            @endif
                        </div>
                    </td>

                    <td class="text-center">
                        <div class="action-group">
                            @if($product->trashed())
                                {{-- Restore --}}
                                <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-icon restore">
                                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 8a5 5 0 108.66-2.5"/>
                                            <polyline points="9,3 13,3 13,7"/>
                                        </svg>
                                        <span class="tip">Pulihkan</span>
                                    </button>
                                </form>
                            @else
                                {{-- Edit --}}
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-icon edit">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 2.5l2.5 2.5-8 8L3 14l.5-2.5 7.5-9z"/>
                                    </svg>
                                    <span class="tip">Edit</span>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon del" onclick="return confirm('Arsipkan produk ini?')">
                                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                                            <polyline points="3,5 13,5"/>
                                            <path d="M6 5V3h4v2"/>
                                            <path d="M4 5l1 8h6l1-8"/>
                                        </svg>
                                        <span class="tip">Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="lh-footer">
        <span class="lh-count">Menampilkan {{ count($products) }} produk</span>
    </div>

</div>
@endsection
