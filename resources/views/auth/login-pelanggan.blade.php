<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Pelanggan — Dapur Gila</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-body text-white font-body">

<section class="auth-page" style="background:var(--bg-body);">
    <!-- Dekorasi background -->
    <div style="position:absolute;top:-20%;right:-15%;width:500px;height:500px;background:radial-gradient(circle,rgba(194,32,32,0.15) 0%,transparent 65%);pointer-events:none;animation:authBlob 18s ease-in-out infinite;"></div>
    <div style="position:absolute;bottom:-15%;left:-10%;width:400px;height:400px;background:radial-gradient(circle,rgba(194,32,32,0.08) 0%,transparent 65%);pointer-events:none;animation:authBlob 22s ease-in-out infinite reverse;"></div>

    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-fire" style="color:var(--accent-light);font-size:1.5rem;"></i>
                <span class="font-display" style="font-size:1.35rem;font-weight:700;">Ramen Dapur Gila</span>
            </div>
            <p style="color:var(--fg-muted);font-size:0.85rem;margin-top:0.35rem;">Masukkan email dan password anda</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       class="form-input @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus
                       placeholder="nama@email.com">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-password">
                    <input type="password" id="password" name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           required placeholder="Masukkan password">
                    <button type="button" class="btn-toggle-pw" onclick="togglePw('password', this)" aria-label="Toggle password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row" style="justify-content:flex-start;margin-bottom:1.5rem;">
                <label class="form-check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn-primary btn-full" style="padding:0.85rem;font-size:0.92rem;border-radius:10px;">
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <div class="auth-footer" style="margin-top:1.75rem;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:var(--accent-light);font-weight:700;">Daftar</a>
        </div>

    </div>
</section>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>