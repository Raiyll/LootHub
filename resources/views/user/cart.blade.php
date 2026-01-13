@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-cart-fill me-2"></i>Keranjang Belanja</h2>
        <a href="{{ route('homepage') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Lanjut Belanja
        </a>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th>Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr>
                                <td class="ps-4 py-3">
                                    <span class="fw-bold text-dark">{{ $details['name'] }}</span>
                                </td>
                                <td class="py-3">Rp {{ number_format($details['price']) }}</td>
                                <td class="py-3 text-center">{{ $details['quantity'] }}</td>
                                <td class="py-3 text-end pe-4 fw-bold">
                                    Rp {{ number_format($details['price'] * $details['quantity']) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Barang</span>
                        <span>{{ count(session('cart')) }} Item</span>
                    </div>
                    <hr class="bg-secondary">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Total Bayar</span>
                        <span class="h5 fw-bold text-warning">Rp {{ number_format($total) }}</span>
                    </div>

                   <form action="{{ route('checkout') }}" method="POST">
    @csrf
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Metode Pembayaran</h5>
            <div class="row">
                <div class="col-md-4">
                    <input type="radio" class="btn-check" name="payment_method" id="debit" value="Debit" required>
                    <label class="btn btn-outline-primary w-100" for="debit">Debit Card</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" class="btn-check" name="payment_method" id="credit" value="Kredit">
                    <label class="btn btn-outline-primary w-100" for="credit">Kartu Kredit</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" class="btn-check" name="payment_method" id="qr" value="QRIS">
                    <label class="btn btn-outline-primary w-100" for="qr">QRIS / QR</label>
                </div>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">Checkout</button>
</form>
                    
                    <p class="small text-muted text-center mt-3">
                        <i class="bi bi-shield-check"></i> Transaksi Aman & Terenkripsi
                    </p>
                </div>
            </div>
            
            <a href="{{ route('cart.clear') }}" class="btn btn-link btn-sm text-danger w-100 mt-2 text-decoration-none">
                Kosongkan Keranjang
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
        <h4 class="mt-3 fw-bold">Keranjang lo kosong, Bre!</h4>
        <p class="text-muted">Kayaknya lo belum looting barang apa-apa hari ini.</p>
        <a href="{{ route('homepage') }}" class="btn btn-primary px-5 mt-3">Cek Katalog Produk</a>
    </div>
    @endif
</div>
@endsection