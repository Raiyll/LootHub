@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">📜Riwayat Pesanan Lo</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">Belum ada pesanan, Bre. Yuk belanja dulu!</div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold text-primary">{{ $order->invoice_number }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($order->total_price) }}</td>
                            <td>
                                <a href="{{ route('transaction.receipt', $order->id) }}" class="btn btn-sm btn-outline-dark">
                                    Lihat Struk
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
    <a href="{{ route('homepage') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
</div>
@endsection