@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --pink:       #ff2d8d;
        --pink-dim:   rgba(255,45,141,0.08);
        --pink-border:rgba(255,45,141,0.2);
        --ink:        #111118;
        --mid:        #4a4a60;
        --muted:      #9494aa;
        --line:       #ebebf2;
        --bg:         #ffffff;
        --bg-soft:    #f8f8fc;
        --green:      #00c97a;
    }

    * { box-sizing: border-box; }

    body {
        background: var(--bg) !important;
        font-family: 'Syne', sans-serif;
        color: var(--ink);
    }

    /* ── WRAPPER ── */
    .wl {
        max-width: 1360px;
        margin: 0 auto;
        padding: 44px 40px 80px;
    }

    /* ── HEADER ── */
    .wl-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 40px;
        padding-bottom: 32px;
        border-bottom: 1.5px solid var(--line);
        position: relative;
    }

    .wl-header::after {
        content: '';
        position: absolute;
        bottom: -1.5px;
        left: 0;
        width: 60px;
        height: 2.5px;
        background: var(--pink);
        border-radius: 2px;
    }

    .wl-eyebrow {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 3.5px;
        text-transform: uppercase;
        color: var(--pink);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .wl-eyebrow::before {
        content: '';
        width: 22px;
        height: 2px;
        background: var(--pink);
        border-radius: 1px;
        display: inline-block;
    }

    .wl-title {
        font-size: clamp(34px, 5vw, 52px);
        font-weight: 800;
        color: var(--ink);
        line-height: 1;
        margin: 0 0 14px;
        letter-spacing: -1px;
    }

    .wl-title span { color: var(--pink); }

    .wl-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--pink-dim);
        border: 1px solid var(--pink-border);
        color: var(--pink);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 6px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: var(--bg);
        color: var(--muted);
        border: 1.5px solid var(--line);
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Syne', sans-serif;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
        margin-bottom: 4px;
    }

    .btn-back:hover {
        border-color: var(--pink);
        color: var(--pink);
        background: var(--pink-dim);
    }

    /* ── SORT BAR ── */
    .wl-sortbar {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .sort-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-right: 4px;
    }

    .sort-btn {
        background: var(--bg);
        border: 1.5px solid var(--line);
        color: var(--muted);
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
        font-family: 'Syne', sans-serif;
    }

    .sort-btn:hover, .sort-btn.active {
        background: var(--pink-dim);
        border-color: var(--pink-border);
        color: var(--pink);
    }

    /* ── GRID ── */
    .wl-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(272px, 1fr));
        gap: 20px;
    }

    /* ── CARD ── */
    .wl-card {
        background: var(--bg);
        border: 1.5px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1),
                    border-color 0.25s,
                    box-shadow 0.3s;
    }

    .wl-card:hover {
        transform: translateY(-6px);
        border-color: var(--pink-border);
        box-shadow: 0 20px 48px rgba(255,45,141,0.08),
                    0 4px 12px rgba(0,0,0,0.06);
    }

    .wl-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: var(--pink);
        border-radius: 16px 16px 0 0;
        opacity: 0;
        transition: opacity 0.25s;
    }

    .wl-card:hover::before { opacity: 1; }

    /* ── IMAGE ── */
    .wl-img {
        position: relative;
        height: 210px;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .wl-img img {
        max-width: 78%;
        max-height: 78%;
        object-fit: contain;
        transition: transform 0.4s cubic-bezier(0.22,1,0.36,1);
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.1));
    }

    .wl-card:hover .wl-img img {
        transform: scale(1.07) translateY(-3px);
    }

    .wl-num {
        position: absolute;
        top: 12px;
        left: 12px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        color: var(--muted);
    }

    .btn-qremove {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: white;
        border: 1.5px solid #ffd6e7;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--pink);
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.2s ease;
    }

    .wl-card:hover .btn-qremove {
        opacity: 1;
        transform: scale(1);
    }

    .btn-qremove:hover {
        background: var(--pink);
        border-color: var(--pink);
        color: white;
    }

    /* ── BODY ── */
    .wl-body {
        padding: 18px 18px 0;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .wl-cat {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--pink);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .wl-cat::before {
        content: '';
        width: 14px;
        height: 1.5px;
        background: var(--pink);
        display: inline-block;
        border-radius: 1px;
    }

    .wl-name {
        font-size: 17px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.35;
        margin-bottom: 16px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
    }

    /* ── PRICE ROW ── */
    .wl-price-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        padding: 14px 0;
        border-top: 1.5px solid var(--line);
    }

    .wl-price-lbl {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 4px;
    }

    .wl-price-val {
        font-size: 21px;
        font-weight: 700;
        color: var(--pink);
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .wl-stock {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--green);
    }

    .stock-dot {
        width: 6px;
        height: 6px;
        background: var(--green);
        border-radius: 50%;
        animation: blink 2s infinite ease-in-out;
        flex-shrink: 0;
    }

    @keyframes blink {
        0%,100% { opacity:1; }
        50%      { opacity:0.3; }
    }

    /* ── ACTIONS ── */
    .wl-actions {
        display: flex;
        border-top: 1.5px solid var(--line);
    }

    .btn-buy {
        flex: 1;
        background: var(--pink);
        color: white;
        border: none;
        padding: 14px 16px;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.2s ease, transform 0.15s ease;
    }

    .btn-buy:hover  { background: #e6007a; }
    .btn-buy:active { transform: scale(0.98); }

    .btn-del {
        width: 50px;
        background: transparent;
        border: none;
        border-left: 1.5px solid var(--line);
        color: var(--muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-del:hover {
        background: var(--pink-dim);
        color: var(--pink);
    }

    /* ── FOOTER ── */
    .wl-card-foot {
        padding: 9px 18px;
        border-top: 1.5px solid var(--line);
        background: var(--bg-soft);
    }

    .wl-date {
        font-size: 10px;
        color: var(--muted);
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* ── EMPTY STATE ── */
    .wl-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 100px 40px;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--pink-dim);
        border: 1.5px solid var(--pink-border);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .wl-empty h3 {
        font-size: 26px;
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .wl-empty p {
        font-size: 14px;
        font-weight: 400;
        color: var(--muted);
        margin-bottom: 28px;
        max-width: 300px;
    }

    .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--pink);
        color: white;
        padding: 13px 28px;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 8px 20px rgba(255,45,141,0.25);
    }

    .btn-browse:hover {
        background: #e6007a;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(255,45,141,0.3);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .wl { padding: 24px 16px 60px; }
        .wl-header { flex-direction: column; align-items: flex-start; }
        .wl-grid {
            grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
            gap: 12px;
        }
        .wl-img { height: 160px; }
        .wl-name { font-size: 14px; }
        .wl-price-val { font-size: 17px; }
        .wl-body { padding: 14px 14px 0; }
        .wl-actions .btn-buy { font-size: 11px; padding: 12px 10px; }
    }
</style>

<div class="wl">

    {{-- ── HEADER ── --}}
    <div class="wl-header">
        <div>
            <div class="wl-eyebrow">Koleksi Saya</div>
            <h1 class="wl-title">Wish<span>list</span></h1>
            @if(!$wishlists->isEmpty())
                <div class="wl-count">
                    {{ $wishlists->count() }} Item Tersimpan
                </div>
            @endif
        </div>

        <a href="{{ route('homepage') }}" class="btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali Looting
        </a>
    </div>

    {{-- ── CONTENT ── --}}
    @if($wishlists->isEmpty())

        <div class="wl-empty">
            <div class="empty-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="#ff2d8d">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <h3>Wishlist Masih Kosong</h3>
            <p>Belum ada gear yang kamu simpan. Mulai hunting sekarang!</p>
            <a href="{{ route('homepage') }}" class="btn-browse">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                Jelajahi Produk
            </a>
        </div>

    @else

        <div class="wl-sortbar">
            <span class="sort-label">Sort</span>
            <button class="sort-btn active">Terbaru</button>
            <button class="sort-btn">Harga Terendah</button>
            <button class="sort-btn">Harga Tertinggi</button>
            <button class="sort-btn">Nama A–Z</button>
        </div>

        <div class="wl-grid">
            @foreach($wishlists as $i => $item)
                <div class="wl-card">

                    <div class="wl-img">
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                             alt="{{ $item->product->name }}" loading="lazy">
                        <span class="wl-num">#{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>

                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST"
                              style="position:absolute;top:10px;right:10px;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-qremove" title="Hapus">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M18 6L6 18M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="wl-body">
                        <div class="wl-cat">Gear Original</div>
                        <h3 class="wl-name">{{ $item->product->name }}</h3>
                        <div class="wl-price-row">
                            <div>
                                <div class="wl-price-lbl">Harga</div>
                                <div class="wl-price-val">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="wl-stock">
                                <span class="stock-dot"></span>
                                Tersedia
                            </div>
                        </div>
                    </div>

                    <div class="wl-actions">
                        <form action="{{ route('cart.add', $item->product->id) }}" method="POST" style="flex:1;display:flex;">
                            @csrf
                            <button type="submit" class="btn-buy">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                Beli Sekarang
                            </button>
                        </form>

                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del" title="Hapus dari Wishlist">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="wl-card-foot">
                        <span class="wl-date">Ditambahkan {{ $item->created_at->diffForHumans() }}</span>
                    </div>

                </div>
            @endforeach
        </div>

    @endif
</div>

@endsection
