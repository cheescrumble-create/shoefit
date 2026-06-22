@extends('layouts.app')

@section('title', 'ShoeFit - Premium Footwear')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
    </div>
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-tag">Performance &middot; Style &middot; Comfort</div>
            <h1 class="hero-title font-display">Step Into<br>Excellence</h1>
            <p class="hero-desc">Discover premium footwear that combines cutting-edge performance with timeless style. Every step is a statement.</p>
            <div class="hero-actions">
                <a href="{{ route('pelanggan.menu') }}" class="btn-primary btn-lg">
                    Explore Collection <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>500+</strong>
                    <span>Shoe Models</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <strong>50K+</strong>
                    <span>Pairs Sold</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <strong>4.9</strong>
                    <span>Rating</span>
                </div>
            </div>
        </div>
        <div class="hero-card">
            @if($produkTerlaris->isNotEmpty())
                @php $featured = $produkTerlaris->first(); @endphp
                <div class="featured-card">
                    <img src="{{ $featured->gambar_url }}" alt="{{ $featured->nama }}" class="featured-img">
                    <span class="featured-badge">Best Seller</span>
                    <div class="featured-info">
                        <h3 class="featured-name">{{ $featured->nama }}</h3>
                        <p class="featured-desc">{{ Str::limit($featured->deskripsi, 60) }}</p>
                        <div class="featured-bottom">
                            <span class="featured-price">{{ $featured->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $featured->id }}">
                                    <button type="submit" class="btn-add-cart" title="Add to Cart">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Featured Shoes -->
<section class="section">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title font-display">Trending Now</h2>
                <p class="section-subtitle">Most loved shoes by our customers</p>
            </div>
            <a href="{{ route('pelanggan.menu', ['sort' => 'terlaris']) }}" class="btn-secondary">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="menu-grid">
            @foreach($produkTerlaris as $item)
                <div class="menu-card">
                    <div class="menu-card-img">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                        @if($item->is_terlaris)
                            <span class="menu-badge menu-badge-hot">Popular</span>
                        @endif
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $item->nama }}</h3>
                        <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
                        <div class="menu-card-bottom">
                            <span class="menu-card-price">{{ $item->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn-add-cart" title="Add to Cart">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- New Arrivals -->
@if($produkBaru->isNotEmpty())
<section class="section" style="background:var(--bg-card);">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title font-display">New Arrivals</h2>
                <p class="section-subtitle">Latest additions to our premium collection</p>
            </div>
        </div>
        <div class="menu-grid">
            @foreach($produkBaru as $item)
                <div class="menu-card">
                    <div class="menu-card-img">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                        <span class="menu-badge menu-badge-new">New</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $item->nama }}</h3>
                        <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
                        <div class="menu-card-bottom">
                            <span class="menu-card-price">{{ $item->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn-add-cart" title="Add to Cart">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
