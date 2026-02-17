@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <div class="rounded-circle p-2 me-3" style="background: linear-gradient(135deg, #4ee6b3 0%, #ff3399 100%);">
                <i class="bi bi-bag-check-fill text-white fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold text-dark mb-0">Review Pesanan</h2>
                <p class="text-muted mb-0 small">Periksa kembali pesanan Anda sebelum melanjutkan</p>
            </div>
        </div>
        
        <!-- Progress Steps -->
        <div class="d-flex align-items-center mt-4 gap-2">
            <div class="flex-grow-1">
                <div class="rounded-pill" style="height: 4px; background: #4ee6b3;"></div>
                <small class="fw-semibold mt-1 d-block" style="color: #4ee6b3;">Keranjang</small>
            </div>
            <div class="flex-grow-1">
                <div class="rounded-pill" style="height: 4px; background: #4ee6b3;"></div>
                <small class="fw-semibold mt-1 d-block" style="color: #4ee6b3;">Pembayaran</small>
            </div>
            <div class="flex-grow-1">
                <div class="rounded-pill" style="height: 4px; background: #ff3399;"></div>
                <small class="fw-semibold mt-1 d-block" style="color: #ff3399;">Review</small>
            </div>
            <div class="flex-grow-1">
                <div class="bg-secondary bg-opacity-25 rounded-pill" style="height: 4px;"></div>
                <small class="text-muted mt-1 d-block">Selesai</small>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Items Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #4ee6b3 0%, #ff3399 100%);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cart3 text-white fs-5 me-2"></i>
                        <h5 class="fw-bold mb-0 text-white">Item Pesanan</h5>
                        <span class="badge bg-white ms-auto" style="color: #ff3399;">{{ count($cart) }} Item</span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @foreach($cart as $id => $details)
                    @php
                        $product = \App\Models\Product::withTrashed()->find($details['product_id']);
                        $isDeleted = $product && $product->trashed();
                    @endphp
                    
                    <div class="item-card position-relative mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        <div class="d-flex align-items-start {{ $isDeleted ? 'opacity-50' : '' }}">
                            <!-- Product Image with Hover Effect -->
                            <div class="position-relative overflow-hidden rounded-3 flex-shrink-0" style="width: 100px; height: 100px; border: 2px solid #4ee6b3;">
                                <img src="{{ asset('storage/' . ($product->image ?? '')) }}" 
                                     class="w-100 h-100 product-image" 
                                     style="object-fit: cover; transition: transform 0.3s ease;">
                                
                                @if($isDeleted)
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge border" style="background-color: #4ee6b3; color: #0f172a;">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $details['quantity'] }} Item
                                    </span>
                                    <span class="text-muted small">×</span>
                                    <span class="fw-semibold" style="color: #ff3399;">Rp {{ number_format($details['price']) }}</span>
                                </div>
                                
                                @if($isDeleted)
                                    <div class="alert alert-danger py-2 px-3 mb-0 d-inline-flex align-items-center" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <small class="mb-0">Produk tidak lagi tersedia</small>
                                    </div>
                                @else
                                    <small style="color: #4ee6b3;">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Tersedia
                                    </small>
                                @endif
                            </div>
                            
                            <!-- Price -->
                            <div class="text-end ms-3">
                                <div class="fw-bold fs-5" style="background: #ff3399; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    Rp {{ number_format($details['price'] * $details['quantity']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Trust Badges -->
            <div class="row g-3 mt-2">
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(78, 230, 179, 0.1) 0%, rgba(78, 230, 179, 0.2) 100%);">
                        <i class="bi bi-shield-check fs-4 mb-2" style="color: #4ee6b3;"></i>
                        <p class="mb-0 small fw-semibold">Pembayaran Aman</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(255, 51, 153, 0.1) 0%, rgba(255, 51, 153, 0.2) 100%);">
                        <i class="bi bi-truck fs-4 mb-2" style="color: #ff3399;"></i>
                        <p class="mb-0 small fw-semibold">Pengiriman Cepat</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(78, 230, 179, 0.1) 0%, rgba(255, 51, 153, 0.1) 100%);">
                        <i class="bi bi-headset fs-4 mb-2" style="color: #4ee6b3;"></i>
                        <p class="mb-0 small fw-semibold">Support 24/7</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <!-- Summary Card with Gradient -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <!-- Gradient Header -->
                        <div class="p-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-receipt-cutoff fs-4 me-2"></i>
                                <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                            </div>
                        </div>
                        
                        <!-- Summary Content -->
                        <div class="p-4">
                            <!-- Payment Method -->
                            <div class="mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, rgba(78, 230, 179, 0.1) 0%, rgba(255, 51, 153, 0.1) 100%);">
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-credit-card me-1"></i>
                                    Metode Pembayaran
                                </small>
                                <div class="d-flex align-items-center">
                                    <span class="badge px-3 py-2 fs-6 fw-semibold text-white" 
                                          style="background: #ff3399;">
                                        {{ strtoupper($paymentMethod ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Price Breakdown -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal Produk</span>
                                    <span class="fw-semibold">Rp {{ number_format($total) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Biaya Layanan</span>
                                    <span class="fw-semibold" style="color: #4ee6b3;">Gratis</span>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <!-- Total -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">Total Bayar</span>
                                    <div class="text-end">
                                        <div class="fw-bold fs-3" style="background: #ff3399; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                            Rp {{ number_format($total) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                                <button type="submit" class="btn w-100 fw-bold py-3 rounded-pill position-relative overflow-hidden border-0 checkout-btn text-white" 
                                        style="background: #156EFD; box-shadow: 0 10px 30px rgba(78, 230, 179, 0.3);">
                                    <span class="position-relative" style="z-index: 1;">
                                        <i class="bi bi-lock-fill me-2"></i>
                                        KONFIRMASI & BAYAR SEKARANG
                                    </span>
                                </button>
                            </form>
                            
                            <!-- Security Note -->
                            <p class="text-center text-muted small mb-0 mt-3">
                                <i class="bi bi-shield-lock-fill me-1" style="color: #4ee6b3;"></i>
                                Transaksi Anda dilindungi dengan enkripsi SSL
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Promo Banner -->
                <div class="card border-0 shadow-sm rounded-4 mt-3 overflow-hidden">
                    <div class="card-body p-3" style="background: linear-gradient(135deg, rgba(78, 230, 179, 0.15) 0%, rgba(255, 51, 153, 0.15) 100%);">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3" style="background: linear-gradient(135deg, #4ee6b3 0%, #ff3399 100%);">
                                <i class="bi bi-gift-fill text-white fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold small">Dapatkan poin reward!</p>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">Belanja minimal Rp 500.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-image:hover {
        transform: scale(1.1);
    }
    
    .checkout-btn {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }
    
    .checkout-btn:hover::before {
        left: 100%;
    }
    
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(255, 51, 153, 0.4) !important;
    }
    
    .checkout-btn:active {
        transform: translateY(0);
    }
    
    .item-card {
        transition: all 0.3s ease;
    }
    
    .item-card:hover {
        background: linear-gradient(135deg, rgba(78, 230, 179, 0.03) 0%, rgba(255, 51, 153, 0.03) 100%);
        margin-left: -8px;
        margin-right: -8px;
        padding-left: 8px;
        padding-right: 8px;
        border-radius: 8px;
    }
</style>
@endsection