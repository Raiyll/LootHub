<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pilih Produk</h5>
                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light me-2">Dashboard</a>
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-info text-white me-2">Cek Stok</a>
                            <a href="{{ route('transaction.history') }}" class="btn btn-sm btn-warning text-dark">Riwayat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($products as $p)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 shadow-sm border-primary">
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold">{{ $p->name }}</h6>
                                        <small class="text-muted d-block mb-2">{{ $p->game_name ?? 'Physical Gear' }}</small>
                                        <p class="text-primary fw-bold mb-3">Rp {{ number_format($p->price) }}</p>
                                        <a href="{{ route('cart.add', $p->id) }}" class="btn btn-sm btn-primary w-100 {{ $p->stock <= 0 ? 'disabled' : '' }}">
                                            {{ $p->stock > 0 ? '+ Tambah' : 'Habis' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Keranjang Belanja</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td><small>{{ $details['name'] }}</small></td>
                                        <td>{{ $details['quantity'] }}</td>
                                        <td>{{ number_format($details['price'] * $details['quantity']) }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Keranjang Kosong</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-auto">
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Total:</h5>
                                <h4 class="text-danger fw-bold">Rp {{ number_format($total) }}</h4>
                            </div>
                            
                            <a href="{{ route('cart.clear') }}" class="btn btn-outline-secondary btn-sm w-100 mb-2">Reset Keranjang</a>
                            
                            <button type="button" class="btn btn-success btn-lg w-100 shadow" data-bs-toggle="modal" data-bs-target="#modalCheckout" {{ $total == 0 ? 'disabled' : '' }}>
                                BAYAR SEKARANG
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCheckout" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-dark">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h4 class="text-center mb-1 text-muted small">TOTAL TAGIHAN</h4>
                        <h2 class="text-center mb-4 text-danger fw-bold">Rp {{ number_format($total) }}</h2>
                        
                        <div class="mb-3">
                            <label class="fw-bold mb-1">Uang Bayar (Rp)</label>
                            <input type="number" name="pay_amount" class="form-control form-control-lg border-primary" id="input_bayar" required min="{{ $total }}" placeholder="0">
                        </div>

                        <div class="p-3 bg-light rounded border">
                            <h6 class="mb-0 text-muted">Kembalian:</h6>
                            <h3 class="mb-0 text-primary fw-bold">Rp <span id="text_kembalian">0</span></h3>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">PROSES SEKARANG</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const totalTagihan = parseInt("{{ $total }}");
        const inputBayar = document.getElementById('input_bayar');
        const textKembalian = document.getElementById('text_kembalian');

        inputBayar.addEventListener('input', function() {
            const bayar = parseInt(this.value) || 0;
            const kembalian = bayar - totalTagihan;
            textKembalian.innerText = new Intl.NumberFormat('id-ID').format(kembalian > 0 ? kembalian : 0);
        });
    </script>
</body>
</html>