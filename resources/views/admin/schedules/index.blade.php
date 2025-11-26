@extends('layouts.admin')

@section('title', 'Manajemen Jadwal - Admin Panel')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-calendar-alt"></i> Manajemen Jadwal Presensi
            </h1>
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Jadwal</h5>
            </div>
            <div class="card-body">
                @if($schedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Toleransi (menit)</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $index => $schedule)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $schedule->jam_masuk }}</td>
                                        <td>{{ $schedule->jam_pulang }}</td>
                                        <td>{{ $schedule->toleransi }}</td>
                                        <td>{{ $schedule->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada jadwal</h5>
                        <p class="text-muted">Belum ada jadwal presensi yang dibuat.</p>
                        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Jadwal Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection