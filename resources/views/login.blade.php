<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistemy</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class='bx bx-book-bookmark logo-icon'></i>
                <h1>Sistemy</h1>
                <p>Silakan masuk ke akun Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); color: #10B981; border: 1.5px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 12px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bx-check-circle' style="font-size: 18px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1.5px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 12px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bx-error-circle' style="font-size: 18px;"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Email / Username</label>
                    <div class="input-group">
                        <input type="text" name="login" class="form-control" placeholder="Masukkan email atau username" required autofocus>
                        <i class='bx bx-user'></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        <i class='bx bx-lock-alt'></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Masuk Sekarang
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <a href="{{ route('auth.google') }}" class="btn-google">
                <i class='bx bxl-google'></i> Masuk dengan Google
            </a>

            <div class="login-footer">
                Belum punya akun? <a href="#">Hubungi Admin</a>
            </div>
        </div>
    </div>

</body>
</html>
