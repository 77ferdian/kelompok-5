@extends('layouts.app')

@section('title', 'Tambah Booking - Sistem Booking Kendaraan')

@section('content')

{{-- HERO KECIL & RINGKAS --}}
<div class="page-hero" style="padding: 16px 0 32px;">
    <div class="container-lg d-flex align-items-center justify-content-between">
        <div>
            <h1 class="hero-title mb-0" style="font-size: 1.35rem;">
                <i class="bi bi-plus-circle-fill me-2"></i>Form Booking Baru
            </h1>
        </div>
        <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-light" style="border-radius: 8px; font-weight: 500; font-size: 0.85rem;">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="main-content" style="margin-top: -18px; padding-bottom: 24px;">
    <div class="container-lg">
        @if ($errors->any())
            <div class="alert-custom alert-error-custom mb-3 py-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div style="font-size: 0.85rem;">
                    <strong>Booking belum dapat disimpan:</strong>
                    <span class="ms-1">{{ implode(', ', $errors->all()) }}</span>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <div class="form-card">
                    <div class="form-card-body p-3 p-md-4">
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf

                            <div class="row g-2 g-md-3">
                                {{-- Nama Pemesan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-person-fill me-1"></i>Nama Pemesan
                                    </label>
                                    <input
                                        type="text"
                                        name="nama_pemesan"
                                        class="form-control-custom py-2"
                                        placeholder="Masukkan nama lengkap"
                                        value="{{ old('nama_pemesan') }}"
                                        required
                                    >
                                </div>

                                {{-- No HP --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-telephone-fill me-1"></i>Nomor HP / WhatsApp
                                    </label>
                                    <input
                                        type="text"
                                        name="no_hp"
                                        class="form-control-custom py-2"
                                        placeholder="Contoh: 08123456789"
                                        value="{{ old('no_hp') }}"
                                        required
                                    >
                                </div>

                                {{-- Jenis Kendaraan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-tags-fill me-1"></i>Jenis Kendaraan
                                    </label>
                                    <select name="jenis_kendaraan" class="form-select-custom py-2" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kendaraan --</option>
                                        <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>
                                            Mobil
                                        </option>
                                        <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>
                                            Motor
                                        </option>
                                    </select>
                                </div>

                                {{-- Nama Kendaraan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-car-front-fill me-1"></i>Nama Kendaraan / Tipe Unit
                                    </label>
                                    <input
                                        type="text"
                                        name="nama_kendaraan"
                                        class="form-control-custom py-2"
                                        placeholder="Contoh: Avanza, NMAX, Beat, dll."
                                        value="{{ old('nama_kendaraan') }}"
                                        required
                                    >
                                </div>

                                {{-- Tanggal Sewa --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-calendar-event-fill me-1"></i>Tanggal Sewa
                                    </label>
                                    <input
                                        type="date"
                                        name="tanggal_sewa"
                                        class="form-control-custom py-2"
                                        value="{{ old('tanggal_sewa', date('Y-m-d')) }}"
                                        required
                                    >
                                </div>

                                {{-- Lama Sewa --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-hourglass-split me-1"></i>Lama Sewa (Hari)
                                    </label>
                                    <input
                                        type="number"
                                        name="lama_sewa"
                                        class="form-control-custom py-2"
                                        placeholder="Min. 1 hari"
                                        min="1"
                                        value="{{ old('lama_sewa', 1) }}"
                                        required
                                    >
                                </div>

                                {{-- Catatan --}}
                                <div class="col-12">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-chat-left-text-fill me-1"></i>Catatan (Opsional)
                                    </label>
                                    <textarea
                                        name="catatan"
                                        class="form-control-custom py-1"
                                        rows="2"
                                        placeholder="Tambahkan catatan khusus jika diperlukan..."
                                    >{{ old('catatan') }}</textarea>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="col-12 d-flex gap-2 mt-2">
                                    <button type="submit" class="btn-primary-custom flex-fill justify-content-center py-2">
                                        <i class="bi bi-check-lg"></i> Simpan Booking
                                    </button>
                                    <a href="{{ route('bookings.index') }}" class="btn-secondary-custom flex-fill py-2">
                                        <i class="bi bi-x-lg"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
