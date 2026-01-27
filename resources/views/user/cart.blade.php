@extends('layouts.app')

@section('title', 'Shopping Cart - LootHub')

@section('content')
<div class="container py-5">
    <div class="row mb-5 align-items-end">
        <div class="col">
            <h2 class="fw-bold text-dark mb-0">Keranjang Belanja</h2>
            <p class="text-muted mb-0">Pilih metode pembayaran dan amankan loot lu.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('homepage') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                <i class="bi bi-chevron-left"></i> Lanjut Looting
            </a>
        </div>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
    @php $totalSemua = 0; @endphp {{-- Inisialisasi total di awal --}}
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-responsive bg-white p-3 rounded-4 shadow-sm">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>PRODUK</th>
                            <th class="text-center">QTY</th>
                            <th class="text-end">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $details)
                            @php
                                // Ambil data produk termasuk yang sudah di-soft delete
                                $p = \App\Models\Product::withTrashed()->find($details['product_id']);
                                $isTrashed = $p && $p->trashed();
                                
                                // Hanya tambahkan ke total jika produk TIDAK di-soft delete
                                if(!$isTrashed) {
                                    $totalSemua += $details['price'] * $details['quantity'];
                                }
                            @endphp
                            <tr class="{{ $isTrashed ? 'opacity-50' : '' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong class="d-block">{{ $details['name'] }}</strong>
                                            
                                            {{-- Info ID Game --}}
                                            @if(isset($details['player_data']) && $details['player_data'])
                                                <div class="small text-primary mt-1">
                                                    <i class="bi bi-person-badge"></i> ID: {{ $details['player_data'] }}
                                                </div>
                                            @endif

                                            {{-- Label Soft Delete --}}
                                            @if($isTrashed)
                                                <span class="badge bg-danger mt-2">Produk Tidak Tersedia / Diarsipkan</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $details['quantity'] }}</td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($details['price'] * $details['quantity']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-2 border-top">
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Yakin mau buang semua loot di tas?')">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none small p-0 fw-medium">
                            <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="payment_method" id="selected_method" required>

                <div class="card border-0 shadow-lg" style="background: #1e293b; color: #fff; border-radius: 20px; position: sticky; top: 2rem;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                        <p class="small fw-bold text-uppercase opacity-50 mb-3">Pilih Pembayaran</p>

                        <div class="row g-2 mb-4">
                            <div class="col-4 text-center">
                                <div class="payment-box" id="box-debit" onclick="selectPayment('Debit')"
                                    style="cursor:pointer; padding:15px 5px; border:2px solid #334155; border-radius:12px; background:#2d3748; transition:0.2s;">
                                    <i class="bi bi-credit-card fs-3 d-block mb-1"></i>
                                    <span class="small fw-bold">Debit</span>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="payment-box" id="box-kredit" onclick="selectPayment('Kredit')"
                                    style="cursor:pointer; padding:15px 5px; border:2px solid #334155; border-radius:12px; background:#2d3748; transition:0.2s;">
                                    <i class="bi bi-wallet2 fs-3 d-block mb-1"></i>
                                    <span class="small fw-bold">Kredit</span>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="payment-box" id="box-qris" onclick="selectPayment('QRIS')"
                                    style="cursor:pointer; padding:15px 5px; border:2px solid #334155; border-radius:12px; background:#2d3748; transition:0.2s;">
                                    <i class="bi bi-qr-code-scan fs-3 d-block mb-1"></i>
                                    <span class="small fw-bold">QRIS</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <span class="opacity-75">Total Bayar:</span>
                            <h3 class="text-info fw-bold mb-0">
                                Rp {{ number_format($totalSemua) }}
                            </h3>
                        </div>

                        {{-- Tombol Checkout Mati kalau ada produk yang di-Soft Delete --}}
                        @php
                            $anyTrashed = collect(session('cart'))->contains(function($item) {
                                $p = \App\Models\Product::withTrashed()->find($item['product_id']);
                                return $p && $p->trashed();
                            });
                        @endphp

                        @if($anyTrashed)
                            <div class="alert alert-warning border-0 small text-dark fw-bold mb-3">
                                Ada item yang tidak tersedia. Hapus dulu/Kosongkan keranjang untuk lanjut.
                            </div>
                            <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold py-3 opacity-50" disabled>
                                TIDAK BISA CHECKOUT
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow border-0" style="border-radius: 12px; background-color: #0d6efd;">
                                CHECKOUT SEKARANG
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    {{-- Tampilan Tas Kosong tetep sama --}}
    <div class="text-center py-5 shadow-sm bg-white rounded-4 border">
        <div class="display-1 text-muted opacity-25 mb-4">
            <i class="bi bi-cart-x"></i>
        </div>
        <h3 class="fw-bold">Tas lo kosong melompong, Bre!</h3>
        <p class="text-muted mb-4">Gak ada item yang bisa di-loot sekarang. Yuk cek katalog dulu.</p>
        <a href="{{ route('homepage') }}" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow">
            <i class="bi bi-search me-2"></i> Cari Produk Seru
        </a>
    </div>
    @endif
</div>

<script>
    // Script selectPayment lu udah bener, biarin aja di bawah sini
    function selectPayment(method) {
        const boxes = document.querySelectorAll('.payment-box');
        boxes.forEach(box => {
            box.style.borderColor = "#334155";
            box.style.background = "#2d3748";
            box.style.color = "#a0aec0";
            box.style.boxShadow = "none";
        });

        const activeBox = document.getElementById('box-' + method.toLowerCase());
        activeBox.style.borderColor = "#0d6efd";
        activeBox.style.background = "rgba(13, 110, 253, 0.1)";
        activeBox.style.color = "#fff";
        activeBox.style.boxShadow = "0 0 15px rgba(13, 110, 253, 0.3)";

        document.getElementById('selected_method').value = method;
    }
</script>
@endsection