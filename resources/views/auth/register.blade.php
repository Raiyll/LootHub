<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LootHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .register-logo img {
            max-height: 150px;
            /* margin-bottom: 1rem; */
        }

        .form-label {
            font-size: 0.875rem;
            color: #475569;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #1a1a1a;
            box-shadow: none;
        }

        .btn-register {
            background-color: #1a1a1a;
            color: white;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background-color: #000;
            transform: translateY(-1px);
        }

        .btn-google {
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            color: #1a1a1a;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider:not(:empty)::before { margin-right: .75rem; }
        .divider:not(:empty)::after { margin-left: .75rem; }

        .login-link {
            color: #1a1a1a;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="text-center">
            <div class="register-logo">
                <img src="{{ asset('images/icontrans.png') }}" alt="LootHub Logo">
            </div>
            <h3 class="fw-bold text-dark mb-1">Daftar Akun</h3>
            <p class="text-muted small mb-4">Bergabung dengan LootHub untuk pengalaman gaming terbaik.</p>
        </div>

        <a href="{{ route('google.login') }}" class="btn btn-google w-100">
            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
            </svg>
            Daftar dengan Google
        </a>

        <div class="divider text-uppercase fw-bold">Atau isi form</div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Gaming">
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Konfirmasi</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-register">Daftar Sekarang</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted small">Udah punya akun? <a href="{{ route('login') }}" class="login-link">Login di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>