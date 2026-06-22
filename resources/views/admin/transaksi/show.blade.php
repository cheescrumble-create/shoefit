@extends('layouts.admin')

@section('page-title', 'Detail Transaksi')

@section('content')
<a href="{{ route('admin.transaksi.index') }}"
   class="btn-back"
   style="margin-bottom:1.5rem;display:inline-flex;">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="checkout-grid" style="display:flex; flex-direction:column; gap:1.5rem;">

    <!-- Informasi Transaksi -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">{{ $transaksi->kode_transaksi }}</h3>
            <span class="badge badge-{{ $transaksi->status_color }}"
                  style="font-size:0.85rem; padding:0.35rem 0.85rem;">
                {{ $transaksi->status_label }}
            </span>
        </div>

        <div class="detail-info">
            <div class="detail-row">
                <span>Pelanggan :</span>
                <span>{{ $transaksi->user->nama }} ({{ $transaksi->user->email }})</span>
            </div>

            <div class="detail-row">
                <span>Tanggal :</span>
                <span>{{ $transaksi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
            </div>

            <div class="detail-row">
                <span>Pembayaran :</span>
                <span style="text-transform:capitalize;">
                    {{ $transaksi->metode_pembayaran }}
                </span>
            </div>

            <div class="detail-row">
                <span>Alamat :</span>
                <span>{{ $transaksi->alamat_pengiriman }}</span>
            </div>

            @if($transaksi->catatan)
                <div class="detail-row">
                    <span>Catatan :</span>
                    <span>{{ $transaksi->catatan }}</span>
                </div>
            @endif

            {{-- Bukti Pembayaran --}}
            @if($transaksi->bukti_pembayaran)
                <div class="detail-row" style="align-items:flex-start;">
                    <span>Bukti Pembayaran :</span>
                    <div>
                        <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}"
                           target="_blank"
                           class="btn-sm btn-outline"
                           style="margin-bottom:0.75rem; display:inline-flex;">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    </div>
                </div>
            @elseif(in_array($transaksi->metode_pembayaran, ['qris', 'transfer']))
                <div class="detail-row">
                    <span>Bukti Pembayaran :</span>
                    <span style="color:var(--text-muted); font-style:italic;">
                        Belum diupload
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Update Status -->
    <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom:1rem;">Update Status</h3>

        @if(in_array($transaksi->status, ['menunggu', 'diproses']))
            <form method="POST"
                  action="{{ route('admin.transaksi.update-status', $transaksi) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status">Ubah Status</label>
                    <select id="status"
                            name="status"
                            class="form-select"
                            required>
                        @if($transaksi->status === 'menunggu')
                            <option value="">Pilih status...</option>
                            <option value="diproses">Diproses</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        @elseif($transaksi->status === 'diproses')
                            <option value="">Pilih status...</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        @endif
                    </select>
                </div>

                <button type="submit" class="btn-primary btn-sm">
                    Update Status
                </button>
            </form>
        @else
            <p style="color:var(--text-muted);">
                Transaksi sudah {{ strtolower($transaksi->status_label) }}, tidak bisa diubah.
            </p>
        @endif

        <!-- Item Pesanan -->
        <div style="margin-top:1.5rem;">
            <h4 style="font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;">
                Item Pesanan
            </h4>

            @foreach($transaksi->detailTransaksi as $d)
                <div class="checkout-item">
                    <span>{{ $d->jumlah }}x {{ $d->produk->nama }}</span>
                    <span>{{ $d->subtotal_formatted }}</span>
                </div>
            @endforeach

            <div class="checkout-total">
                <span>Total</span>
                <strong>{{ $transaksi->total_harga_formatted }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection