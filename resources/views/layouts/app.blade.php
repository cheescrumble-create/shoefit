<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShoeFit - Premium Footwear')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body class="bg-body text-white font-body">

    <!-- ==================== NAVIGASI ==================== -->
    <nav class="nav-main">
        <div class="nav-container">
            <a href="{{ route('beranda') }}" class="nav-brand">
                <i class="fas fa-shoe-prints" style="color:var(--accent);"></i>
                <span class="font-display" style="font-weight:700;">ShoeFit</span>
            </a>

            <div class="nav-links" id="navLinks">
                <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">Home</a>
                <a href="{{ route('pelanggan.menu') }}" class="nav-link {{ request()->routeIs('pelanggan.menu') ? 'active' : '' }}">Shop</a>
            </div>

            <div class="nav-actions">
                @auth
                    @if(auth()->user()->isPelanggan())
                        <a href="{{ route('pelanggan.keranjang') }}" class="btn-nav btn-outline" style="position:relative;">
                            <i class="fas fa-shopping-bag"></i>
                            @php $totalKeranjang = auth()->user()->total_keranjang; @endphp
                            @if($totalKeranjang > 0)
                                <span class="cart-badge">{{ $totalKeranjang }}</span>
                            @endif
                        </a>
                    @endif

                    <div class="nav-dropdown" id="navDropdown">
                        <button class="btn-nav btn-outline" onclick="toggleDropdown()">
                            <i class="fas fa-user-circle"></i>
                            <span class="hidden sm:inline">{{ auth()->user()->nama }}</span>
                            <i class="fas fa-chevron-down" style="font-size:0.6rem;margin-left:0.15rem;"></i>
                        </button>
                        <div class="dropdown-menu" id="dropdownMenu">
                            @if(auth()->user()->isPelanggan())
                                <a href="{{ route('pelanggan.profil') }}" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
                                <a href="{{ route('pelanggan.pesanan') }}" class="dropdown-item"><i class="fas fa-receipt"></i> My Orders</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" style="width:100%;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width:100%;text-align:left;color:#f87171;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button class="nav-toggle" onclick="toggleNav()" aria-label="Toggle menu">
                    <i class="fas fa-bars" id="navToggleIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- ==================== KONTEN UTAMA ==================== -->
    <main>
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-shoe-prints" style="color:var(--accent);font-size:1.2rem;"></i>
                    <span class="font-display" style="font-size:1.1rem;font-weight:700;">ShoeFit</span>
                </div>
                <p style="margin-top:0.5rem;">Premium footwear for every step of your journey. Performance, style, and comfort combined.</p>
            </div>
            <div class="footer-links">
                <h4>Navigation</h4>
                <a href="{{ route('beranda') }}">Home</a>
                <a href="{{ route('pelanggan.menu') }}">Shop</a>
            </div>
            <div class="footer-links">
                <h4>Contact</h4>
                <p><i class="fas fa-phone" style="width:16px;"></i> +1-800-SHOEFIT</p>
                <p><i class="fas fa-envelope" style="width:16px;"></i> hello@shoefit.com</p>
                <p><i class="fas fa-map-marker-alt" style="width:16px;"></i> 123 Fashion Ave, New York, NY</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 ShoeFit. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
