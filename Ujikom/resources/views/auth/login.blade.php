<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eaecef;
            font-weight: 600;
            text-align: center;
            padding: 16px;
            font-size: 1.2rem;
            border-radius: 8px 8px 0 0 !important;
        }
        .card-body {
            padding: 20px 24px;
        }
        .form-control {
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.2);
        }
        .btn-primary {
            background-color: #3b82f6;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .login-icon {
            font-size: 2rem;
            color: #3b82f6;
            display: block;
            margin-bottom: 4px;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-5 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box-arrow-in-right login-icon"></i>
                    Login
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <span>Belum punya akun?</span>
                        <a href="{{ route('register') }}">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>