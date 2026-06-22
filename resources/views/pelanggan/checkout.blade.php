@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="section">
    <div class="section-container" style="max-width:900px;">
        <h2 class="section-title font-display" style="margin-bottom:2rem;">
            <i class="fas fa-credit-card"></i> Checkout
        </h2>

        <form method="POST"
              action="{{ route('pelanggan.checkout.proses') }}"
              enctype="multipart/form-data"
              id="checkoutForm">
            @csrf

            <div class="checkout-grid">
                <!-- Ringkasan Pesanan -->
                <div class="checkout-box">
                    <h3 class="checkout-box-title">Ringkasan Pesanan</h3>

                    <div class="checkout-items">
                        @foreach($items as $item)
                            <div class="checkout-item">
                                <span>{{ $item->jumlah }}x {{ $item->produk->nama }}</span>
                                <span>{{ $item->subtotal_formatted }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="checkout-total">
                        <span>Total</span>
                        <strong>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <!-- Form Checkout -->
                <div class="checkout-box">
                    <h3 class="checkout-box-title">Pengiriman</h3>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat_pengiriman">Alamat Pengiriman</label>
                        <textarea
                            id="alamat_pengiriman"
                            name="alamat_pengiriman"
                            class="form-input"
                            rows="3"
                            required
                            placeholder="Masukkan alamat lengkap pengiriman...">{{ old('alamat_pengiriman', $user->alamat ?? '') }}</textarea>

                        @error('alamat_pengiriman')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="form-group">
                        <label>Metode Pembayaran</label>

                        <div class="payment-options">

                            <!-- COD -->
                            <label class="payment-option @error('metode_pembayaran') is-invalid @enderror">
                                <input type="radio"
                                       name="metode_pembayaran"
                                       value="cod"
                                       {{ old('metode_pembayaran', 'cod') === 'cod' ? 'checked' : '' }}
                                       required>

                                <div class="payment-option-content">
                                    <i class="fas fa-hand-holding-dollar"></i>
                                    <div>
                                        <strong>COD</strong>
                                        <p>Bayar di tempat</p>
                                    </div>
                                </div>
                            </label>

                            <!-- QRIS -->
                            <label class="payment-option @error('metode_pembayaran') is-invalid @enderror">
                                <input type="radio"
                                       name="metode_pembayaran"
                                       value="qris"
                                       {{ old('metode_pembayaran') === 'qris' ? 'checked' : '' }}
                                       required>

                                <div class="payment-option-content">
                                    <i class="fas fa-qrcode"></i>

                                    <div>
                                        <strong>Qris</strong>
                                        <p>Bayar dengan QRIS</p>
                                    </div>

                                    <!-- Tombol Lihat QR -->
                                    <button type="button"
                                            id="showQrisBtn"
                                            class="btn-show-qris"
                                            @if(old('metode_pembayaran') !== 'qris') style="display:none;" @endif>
                                        <i class="fas fa-eye"></i> Lihat QR
                                    </button>
                                </div>
                            </label>

                            <!-- Transfer -->
                            <label class="payment-option @error('metode_pembayaran') is-invalid @enderror">
                                <input type="radio"
                                    name="metode_pembayaran"
                                    value="transfer"
                                    {{ old('metode_pembayaran') === 'transfer' ? 'checked' : '' }}
                                    required>

                                <div class="payment-option-content">
                                    <i class="fas fa-building-columns"></i>

                                    <div>
                                        <strong>Transfer Bank</strong>
                                        <p>BCA / BNI / Mandiri</p>
                                    </div>
                                </div>

                                <!-- Pilihan Bank -->
                                <div id="bankSelection"
                                    class="bank-selection"
                                    @if(old('metode_pembayaran') !== 'transfer') style="display:none;" @endif>
                                    <label for="bank">Pilih Bank</label>

                                    <select name="bank" id="bank" class="form-input">
                                        <option value="">-- Pilih Bank --</option>
                                        <option value="bca" {{ old('bank') === 'bca' ? 'selected' : '' }}>BCA</option>
                                        <option value="bni" {{ old('bank') === 'bni' ? 'selected' : '' }}>BNI</option>
                                        <option value="mandiri" {{ old('bank') === 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                    </select>

                                    <!-- Nomor VA -->
                                    <div id="vaContainer"
                                        class="va-container"
                                        @if(old('bank')) style="display:none;" @endif>
                                        <label>Nomor Virtual Account</label>

                                        <div class="va-box">
                                            <span id="nomorVA"></span>

                                            <button type="button"
                                                    class="copy-btn"
                                                    onclick="copyVA()">
                                                Salin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('metode_pembayaran')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Bukti Pembayaran -->
                    <div class="form-group" id="buktiPembayaranGroup" style="display:none;">
                        <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>

                        <input type="file"
                               id="bukti_pembayaran"
                               name="bukti_pembayaran"
                               class="form-input"
                               accept="image/*,.pdf">

                        <small style="display:block; margin-top:6px; color:#666;">
                            Format JPG, PNG, JPEG, atau PDF. Maksimal 2 MB.
                        </small>

                        @error('bukti_pembayaran')
                            <span class="form-error">{{ $message }}</span>
                        @enderror

                        <!-- Preview -->
                        <div id="previewContainer" style="display:none; margin-top:12px;">
                            <img id="previewImage"
                                 src=""
                                 alt="Preview Bukti Pembayaran"
                                 style="max-width:100%; max-height:250px; border-radius:8px; border:1px solid #ddd;">
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan"
                                  name="catatan"
                                  class="form-input"
                                  rows="2"
                                  placeholder="Contoh: level pedas extra, tidak pakai telur...">{{ old('catatan') }}</textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-primary btn-full">
                        Buat Pesanan <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Modal QRIS -->
<div id="qrisModal"
     style="display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.6);
            z-index:9999;
            justify-content:center;
            align-items:center;">

    <div style="background:#fff;
                padding:24px;
                border-radius:16px;
                max-width:400px;
                width:90%;
                text-align:center;
                position:relative;">

        <!-- Tombol Tutup -->
        <button type="button"
                id="closeQrisModal"
                style="position:absolute;
                       top:10px;
                       right:15px;
                       border:none;
                       background:none;
                       font-size:28px;
                       cursor:pointer;">
            &times;
        </button>

        <h3 style="margin-bottom:16px;">QRIS Pembayaran</h3>

        <!-- Gambar QR -->
        <img src="{{ asset('images/qris.jpg') }}"
             alt="QRIS"
             style="width:250px; max-width:100%; margin-bottom:16px;">

        <p style="font-size:14px; color:#666;">
            Scan QR Code ini untuk melakukan pembayaran.
        </p>
    </div>
</div>

<style>
/* Tombol Lihat QR */
.btn-show-qris {
    margin-left: auto;
    padding: 8px 12px;
    border: none;
    border-radius: 8px;
    background: #e53935;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    white-space: nowrap;
}

.btn-show-qris:hover {
    background: #c62828;
}

/* Payment content */
.payment-option-content {
    display: flex;
    align-items: center;
    gap: 12px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentRadios = document.querySelectorAll('input[name="metode_pembayaran"]');
    const qrisRadio = document.querySelector('input[value="qris"]');
    const transferRadio = document.querySelector('input[value="transfer"]');

    const showQrisBtn = document.getElementById('showQrisBtn');
    const qrisModal = document.getElementById('qrisModal');
    const closeQrisModal = document.getElementById('closeQrisModal');

    const buktiGroup = document.getElementById('buktiPembayaranGroup');
    const buktiInput = document.getElementById('bukti_pembayaran');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    // Tampilkan tombol QR dan upload bukti
    function togglePaymentFields() {
        const selected = document.querySelector('input[name="metode_pembayaran"]:checked');

        // Tombol Lihat QR hanya untuk QRIS
        if (selected && selected.value === 'qris') {
            showQrisBtn.style.display = 'inline-flex';
        } else {
            showQrisBtn.style.display = 'none';
        }

        // Upload bukti untuk QRIS dan Transfer
        if (selected && (selected.value === 'qris' || selected.value === 'transfer')) {
            buktiGroup.style.display = 'block';
            buktiInput.setAttribute('required', 'required');
        } else {
            buktiGroup.style.display = 'none';
            buktiInput.removeAttribute('required');
            buktiInput.value = '';
            previewContainer.style.display = 'none';
            previewImage.src = '';
        }
    }

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', togglePaymentFields);
    });

    togglePaymentFields();

    // Buka modal QR
    if (showQrisBtn) {
        showQrisBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            qrisModal.style.display = 'flex';
        });
    }

    // Tutup modal
    if (closeQrisModal) {
        closeQrisModal.addEventListener('click', function () {
            qrisModal.style.display = 'none';
        });
    }

    // Klik di luar modal
    qrisModal.addEventListener('click', function (e) {
        if (e.target === qrisModal) {
            qrisModal.style.display = 'none';
        }
    });

    // Preview bukti pembayaran
    buktiInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            previewContainer.style.display = 'none';
            previewImage.src = '';
            return;
        }

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
            previewImage.src = '';
        }
    });
});
</script>

<style>
.bank-selection {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.bank-selection label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.va-container {
    margin-top: 1rem;
}

.va-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
    border: 1px dashed #d32f2f;
    border-radius: 8px;
    padding: 12px 16px;
    font-weight: 700;
    color: #d32f2f;
    gap: 1rem;
}

.copy-btn {
    border: none;
    background: #d32f2f;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
}

.copy-btn:hover {
    background: #b71c1c;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const transferRadio = document.querySelector('input[value="transfer"]');
    const bankSelection = document.getElementById('bankSelection');
    const bankSelect = document.getElementById('bank');
    const vaContainer = document.getElementById('vaContainer');
    const nomorVA = document.getElementById('nomorVA');

    // Generate nomor VA berdasarkan bank
    function generateVA(bank) {
        const prefixes = {
            bca: '014',
            bni: '009',
            mandiri: '008'
        };

        if (!prefixes[bank]) {
            return '';
        }

        // Timestamp + random agar unik
        const timestamp = Date.now().toString().slice(-10);
        const random = Math.floor(Math.random() * 900 + 100);

        return prefixes[bank] + timestamp + random;
    }

    // Tampilkan / sembunyikan pilihan bank
    function toggleBankSelection() {
        if (transferRadio && transferRadio.checked) {
            bankSelection.style.display = 'block';
        } else {
            bankSelection.style.display = 'none';
            vaContainer.style.display = 'none';
            nomorVA.textContent = '';
            bankSelect.value = '';
        }
    }

    // Update nomor VA saat bank dipilih
    function updateVA() {
        const bank = bankSelect.value;

        if (!bank) {
            vaContainer.style.display = 'none';
            nomorVA.textContent = '';
            return;
        }

        const va = generateVA(bank);

        nomorVA.textContent = va;
        vaContainer.style.display = 'block';
    }

    // Copy nomor VA
    window.copyVA = function () {
        const va = nomorVA.textContent;

        if (!va) return;

        navigator.clipboard.writeText(va).then(() => {
            alert('Nomor VA berhasil disalin!');
        });
    };

    // Event radio pembayaran
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach(radio => {
        radio.addEventListener('change', toggleBankSelection);
    });

    // Event dropdown bank
    if (bankSelect) {
        bankSelect.addEventListener('change', updateVA);
    }

    // Jalankan saat halaman pertama kali dibuka
    toggleBankSelection();

    // Jika ada old value bank, tampilkan nomor VA
    if (bankSelect && bankSelect.value) {
        updateVA();
    }
});
</script>
@endsection