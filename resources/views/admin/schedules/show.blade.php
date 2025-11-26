@extends('layouts.admin')

@section('title', 'Detail Jadwal - Admin Panel')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-eye"></i> Detail Jadwal Presensi
            </h1>
            <div>
                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Jadwal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jam Masuk</label>
                            <p class="form-control-plaintext">{{ $schedule->jam_masuk }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jam Pulang</label>
                            <p class="form-control-plaintext">{{ $schedule->jam_pulang }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Toleransi Keterlambatan</label>
                            <p class="form-control-plaintext">{{ $schedule->toleransi }} menit</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dibuat Pada</label>
                            <p class="form-control-plaintext">{{ $schedule->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($schedule->updated_at != $schedule->created_at)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Terakhir Diupdate</label>
                                <p class="form-control-plaintext">{{ $schedule->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Confirmation -->
        <div class="card mt-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Zona Bahaya
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-3">Menghapus jadwal ini akan mempengaruhi sistem presensi. Pastikan tidak ada jadwal aktif yang bergantung pada jadwal ini.</p>
                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection