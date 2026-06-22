<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Dapur Gila</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-body text-white font-body">

<section class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-fire"></i>
                <span class="font-display">Ramen Dapur Gila</span>
            </div>
            <p>Buat akun baru untuk mulai memesan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama"
                       class="form-input @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       class="form-input @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-password">
                    <input type="password" id="password" name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw('password', this)" aria-label="Toggle password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-password">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input @error('password_confirmation') is-invalid @enderror"
                           required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw('password_confirmation', this)" aria-label="Toggle password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-primary btn-full">Daftar</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>
</section>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>