@extends('layouts.app')

@section('title', 'Shop - ShoeFit')

@section('content')
<section class="section">
    <div class="section-container">
        <div class="section-header" style="margin-bottom:2rem;">
            <div>
                <h2 class="section-title font-display">Our Collection</h2>
                <p class="section-subtitle">Curated selection of premium footwear for every occasion</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('pelanggan.menu') }}" class="filter-search">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Search shoes..." class="form-input">
                </div>
            </form>
            <div class="filter-sort">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" form="sortForm">
                    <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Latest</option>
                    <option value="termurah" {{ $sort === 'termurah' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="termahal" {{ $sort === 'termahal' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="terlaris" {{ $sort === 'terlaris' ? 'selected' : '' }}>Most Popular</option>
                </select>
                <form id="sortForm" method="GET" action="{{ route('pelanggan.menu') }}" style="display:none;">
                    <input type="hidden" name="cari" value="{{ request('cari') }}">
                </form>
            </div>
        </div>

        <!-- Shoes Grid -->
        @if($produk->isNotEmpty())
            <div class="menu-grid">
                @foreach($produk as $item)
                    <div class="menu-card">
                        <div class="menu-card-img">
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                            @if($item->is_terlaris)
                                <span class="menu-badge menu-badge-hot">Popular</span>
                            @elseif($item->is_baru)
                                <span class="menu-badge menu-badge-new">New</span>
                            @endif
                        </div>
                        <div class="menu-card-body">
                            <span class="menu-card-cat">{{ $item->kategori }}</span>
                            <h3 class="menu-card-title">{{ $item->nama }}</h3>
                            <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 55) }}</p>
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
                                @else
                                    <a href="{{ route('login') }}" class="btn-add-cart" title="Login to Shop">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $produk->withQueryString()->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-shoe-prints"></i>
                <h3>No shoes found</h3>
                <p>Try adjusting your search filters.</p>
            </div>
        @endif
    </div>
</section>
@endsection
