<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stok Gaming Gear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">GAMING POS</a>
            <a class="btn btn-outline-light" href="{{ route('kasir.index') }}">Buka Kasir</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h5>Data Stok Barang</h5></div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Game</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->game_name ?? 'Gear' }}</td>
                            <td>Rp {{ number_format($p->price) }}</td>
                            <td>
                                <span class="badge {{ $p->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $p->stock }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>