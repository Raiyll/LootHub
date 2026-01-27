@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Riwayat Pesanan Lo</h2>

    @if($orders->isEmpty())
    <div class="alert alert-info">Belum ada pesanan, Bre. Yuk belanja dulu!</div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="table-light">
                        <th>Invoice</th>
                        <th>Item & Data Game</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 1. LOOPING UTAMA: Buka bungkus pesanan satu per satu --}}
                    @foreach($orders as $order)
                    <tr>
                        <td class="text-primary">{{ $order->invoice_number }}</td>
                        <td>
                            {{-- 2. LOOPING KEDUA: Tampilkan item di dalam satu invoice tersebut --}}
                            @foreach($order->items as $item)
                            <div class="mb-2">
                                <span class="d-block">{{ $item->product->name }}</span>
                                @if($item->player_data)
                                <small class="text-primary bg-primary bg-opacity-10 px-2 py-1 rounded">
                                    <i class="bi bi-person-badge"></i> ID: {{ $item->player_data }}
                                </small>
                                @endif
                            </div>
                            @endforeach
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="">Rp {{ number_format($order->total_price) }}</td>
                        <td>
                            <a href="{{ route('transaction.receipt', $order->id) }}" class="btn btn-sm btn-dark rounded-pill">
                                <i class="bi bi-receipt"></i> Struk
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