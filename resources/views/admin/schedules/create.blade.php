@extends('layouts.admin')

@section('title', 'Tambah Jadwal - Admin Panel')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-plus"></i> Tambah Jadwal Presensi
            </h1>
            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Jadwal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="jam_masuk" class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror"
                               id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk') }}" required>
                        @error('jam_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Waktu mulai masuk sekolah</div>
                    </div>

                    <div class="mb-3">
                        <label for="jam_pulang" class="form-label">Jam Pulang <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror"
                               id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang') }}" required>
                        @error('jam_pulang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Waktu pulang sekolah</div>
                    </div>

                    <div class="mb-3">
                        <label for="toleransi" class="form-label">Toleransi Keterlambatan (menit) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('toleransi') is-invalid @enderror"
                               id="toleransi" name="toleransi" value="{{ old('toleransi', 15) }}"
                               min="0" max="120" required>
                        @error('toleransi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Batas toleransi keterlambatan dalam menit</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection