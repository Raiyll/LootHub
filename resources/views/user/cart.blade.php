@extends('layouts.app')

@section('title', 'POS Kasir - LootHub')



@section('content')
    <div class="container py-5">
        <div class="row mb-5 align-items-end">
            <div class="col">
                <h2 class="fw-bold text-dark mb-0">POS Kasir</h2>
                <p class="text-muted mb-0">Selesaikan transaksi Looting hari ini.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('homepage') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                    <i class="bi bi-plus-circle"></i> Tambah Item Lagi
                </a>
            </div>
        </div>

        @if (session('cart') && count(session('cart')) > 0)
            @php
                $totalSemua = 0;
                // Definisikan $anyTrashed di sini biar bisa dibaca sampai bawah
                $anyTrashed = collect(session('cart'))->contains(function ($item) {
                    $p = \App\Models\Product::withTrashed()->find($item['product_id']);
                    return $p && $p->trashed();
                });
            @endphp

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="table-responsive bg-white p-4 rounded-4 shadow-sm border">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-muted small">
                                    <th>ITEM LOOT</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-end">HARGA</th>
                                    <th class="text-end">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $details)
                                    @php
                                        $p = \App\Models\Product::withTrashed()->find($details['product_id']);
                                        $isTrashed = $p && $p->trashed();
                                        if (!$isTrashed) {
                                            $totalSemua += $details['price'] * $details['quantity'];
                                        }
                                    @endphp
                                    <tr class="{{ $isTrashed ? 'opacity-50 bg-light' : '' }}">
                                        <td>
                                            <strong class="d-block">{{ $details['name'] }}</strong>
                                            @if (isset($details['player_data']) && $details['player_data'])
                                                <small class="text-primary"><i class="bi bi-controller"></i>
                                                    {{ $details['player_data'] }}</small>
                                            @endif
                                            @if ($isTrashed)
                                                <span class="badge bg-danger d-block mt-1"
                                                    style="width: fit-content;">Produk Dihapus</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $details['quantity'] }}</td>
                                        <td class="text-end text-muted">Rp {{ number_format($details['price']) }}</td>
                                        <td class="text-end fw-bold">
                                            Rp {{ number_format($details['price'] * $details['quantity']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="p-2 border-top mt-3">
                            <form action="{{ route('cart.clear') }}" method="POST"
                                onsubmit="return confirm('Kosongkan semua item?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm border-0 fw-bold">
                                    <i class="bi bi-trash3 me-1"></i> Batal / Bersihkan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <form action="{{ route('checkout.index') }}" method="GET" id="checkoutForm">
                        <input type="hidden" name="payment_method" id="selected_method" required>

                        <div class="card border-0 shadow-lg overflow-hidden"
                            style="background: #1e293b; color: #fff; border-radius: 24px; position: sticky; top: 2rem;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 border-bottom border-secondary pb-3 text-info">Ringkasan POS</h5>

                                <label class="small fw-bold text-uppercase opacity-50 mb-3 d-block">Metode Bayar</label>
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <div class="payment-box" id="box-tunai" onclick="selectPayment('Tunai')"
                                            style="cursor:pointer; padding:15px; border:2px solid #334155; border-radius:12px; background:#2d3748; text-align:center; transition:0.2s;">
                                            <i class="bi bi-cash-stack fs-3 d-block mb-1"></i>
                                            <span class="small fw-bold">Tunai (Cash)</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-box" id="box-qris" onclick="selectPayment('QRIS')"
                                            style="cursor:pointer; padding:15px; border:2px solid #334155; border-radius:12px; background:#2d3748; text-align:center; transition:0.2s;">
                                            <i class="bi bi-qr-code-scan fs-3 d-block mb-1"></i>
                                            <span class="small fw-bold">QRIS</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-box" id="box-debit" onclick="selectPayment('Debit')"
                                            style="cursor:pointer; padding:15px; border:2px solid #334155; border-radius:12px; background:#2d3748; text-align:center; transition:0.2s;">
                                            <i class="bi bi-credit-card fs-3 d-block mb-1"></i>
                                            <span class="small fw-bold">Debit</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-box" id="box-kredit" onclick="selectPayment('Kredit')"
                                            style="cursor:pointer; padding:15px; border:2px solid #334155; border-radius:12px; background:#2d3748; text-align:center; transition:0.2s;">
                                            <i class="bi bi-wallet2 fs-3 d-block mb-1"></i>
                                            <span class="small fw-bold">Kredit</span>
                                        </div>
                                    </div>
                                </div>

                                <div id="tunai-calculator" class="mb-4 d-none">
                                    <label class="small fw-bold text-uppercase opacity-50 mb-2 d-block">Input Uang
                                        Diterima</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text bg-dark border-secondary text-white">Rp</span>
                                        <input type="number" name="pay_amount" id="uang_diterima"
                                            class="form-control bg-dark border-secondary text-white fw-bold"
                                            placeholder="0">
                                    </div>
                                    <div class="d-flex justify-content-between px-1">
                                        <small class="text-light">Kembalian:</small>
                                        <strong id="display_kembalian" class="text-info">Rp 0</strong>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between mb-4 mt-2 py-3 border-top border-secondary align-items-center">
                                    <span class="opacity-75">Total Tagihan:</span>
                                    <h3 class="text-info fw-bold mb-0" id="total_tagihan" data-value="{{ $totalSemua }}">
                                        Rp {{ number_format($totalSemua) }}
                                    </h3>
                                </div>

                                @if ($anyTrashed)
                                    <div class="alert alert-warning border-0 small text-dark fw-bold mb-3">
                                        Ada item kadaluarsa dalam tas.
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold py-3 opacity-50"
                                        disabled>KASIR TERKUNCI</button>
                                @else
                                    <button type="submit" id="btn-checkout"
                                        class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow border-0"
                                        style="border-radius: 12px; background-color: #0d6efd;">
                                        PROSES TRANSAKSI
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center py-5 shadow-sm bg-white rounded-4 border">
                <div class="display-1 text-muted opacity-25 mb-4"><i class="bi bi-cart-x"></i></div>
                <h3 class="fw-bold">Kasir Kosong</h3>
                <p class="text-muted mb-4">Belum ada barang yang mau di-checkout.</p>
                <a href="{{ route('homepage') }}" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow">Mulai
                    Looting</a>
            </div>
        @endif
    </div>

    <script>
        const totalTagihan = parseInt(document.getElementById('total_tagihan').dataset.value);

        function selectPayment(method) {
            document.querySelectorAll('.payment-box').forEach(box => {
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

            // Toggle Kalkulator Tunai
            const calc = document.getElementById('tunai-calculator');
            if (method === 'Tunai') {
                calc.classList.remove('d-none');
                document.getElementById('uang_diterima').required = true;
            } else {
                calc.classList.add('d-none');
                document.getElementById('uang_diterima').required = false;
            }
        }

        // Script Hitung Kembalian
        document.getElementById('uang_diterima')?.addEventListener('input', function() {
            const bayar = parseInt(this.value) || 0;
            const kembalian = bayar - totalTagihan;
            const display = document.getElementById('display_kembalian');
            const btn = document.getElementById('btn-checkout');

            if (kembalian >= 0) {
                display.innerText = "Rp " + kembalian.toLocaleString('id-ID');
                display.classList.replace('text-danger', 'text-info');
                btn.disabled = false;
            } else {
                display.innerText = "Kurang Rp " + Math.abs(kembalian).toLocaleString('id-ID');
                display.classList.replace('text-info', 'text-danger');
                // Jika mau paksa uang harus cukup sebelum checkout:
                // btn.disabled = true;
            }
        });
    </script>
@endsection
