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
            <a class="navbar-brand" href="/">LootHub</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Data Stok Barang</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Stok Barang LootHub</h3>
                    <a href="{{ route('products.create') }}" class="btn btn-success">+ Tambah Produk</a>
                </div>
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
                            <th class="text-center">Aksi</th>
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
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
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