@extends('layouts.app')

@section('title', 'Edit Booking - Sistem Booking Kendaraan')

@section('content')

{{-- HERO KECIL & RINGKAS --}}
<div class="page-hero" style="padding: 16px 0 32px;">
    <div class="container-lg d-flex align-items-center justify-content-between">
        <div>
            <h1 class="hero-title mb-0" style="font-size: 1.35rem;">
                <i class="bi bi-pencil-square me-2"></i>Edit Data Booking
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
                    <strong>Perubahan belum dapat disimpan:</strong>
                    <span class="ms-1">{{ implode(', ', $errors->all()) }}</span>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <div class="form-card">
                    <div class="form-card-body p-3 p-md-4">
                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')

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
                                        value="{{ old('nama_pemesan', $booking->nama_pemesan) }}"
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
                                        value="{{ old('no_hp', $booking->no_hp) }}"
                                        required
                                    >
                                </div>

                                {{-- Jenis Kendaraan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-tags-fill me-1"></i>Jenis Kendaraan
                                    </label>
                                    <select name="jenis_kendaraan" class="form-select-custom py-2" required>
                                        <option value="mobil" {{ (old('jenis_kendaraan', $booking->jenis_kendaraan) == 'mobil') ? 'selected' : '' }}>
                                            Mobil
                                        </option>
                                        <option value="motor" {{ (old('jenis_kendaraan', $booking->jenis_kendaraan) == 'motor') ? 'selected' : '' }}>
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
                                        value="{{ old('nama_kendaraan', $booking->nama_kendaraan) }}"
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
                                        value="{{ old('tanggal_sewa', $booking->tanggal_sewa) }}"
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
                                        min="1"
                                        value="{{ old('lama_sewa', $booking->lama_sewa) }}"
                                        required
                                    >
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-circle-half me-1"></i>Status Booking
                                    </label>
                                    <select name="status" class="form-select-custom py-2">
                                        <option value="menunggu"  {{ (old('status', $booking->status) == 'menunggu')  ? 'selected' : '' }}>Menunggu</option>
                                        <option value="disetujui" {{ (old('status', $booking->status) == 'disetujui') ? 'selected' : '' }}>Disetujui</option>
                                        <option value="selesai"   {{ (old('status', $booking->status) == 'selesai')   ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal"     {{ (old('status', $booking->status) == 'batal')     ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>

                                {{-- Catatan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom mb-1">
                                        <i class="bi bi-chat-left-text-fill me-1"></i>Catatan (Opsional)
                                    </label>
                                    <textarea
                                        name="catatan"
                                        class="form-control-custom py-1"
                                        rows="1"
                                        placeholder="Catatan tambahan..."
                                    >{{ old('catatan', $booking->catatan) }}</textarea>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="col-12 d-flex gap-2 mt-2">
                                    <button type="submit" class="btn-primary-custom flex-fill justify-content-center py-2">
                                        <i class="bi bi-save-fill"></i> Simpan Perubahan
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
