@extends('layouts.app')

@section('title', 'Dashboard - Sistemy')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="stats-grid">
    <!-- Stat Card 1 -->
    <div class="stat-card">
        <div class="stat-icon">
            <i class='bx bx-file'></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Minuta</div>
            <div class="stat-value">{{ $totalMinuta }}</div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
            <i class='bx bx-folder-open'></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total BAST</div>
            <div class="stat-value">{{ $totalBast }}</div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
            <i class='bx bx-user-circle'></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Staff</div>
            <div class="stat-value">{{ $totalStaff }}</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Aktivitas Terbaru</div>
            <a href="{{ route('minuta.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aktivitas</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMinutas as $minuta)
                    <tr>
                        <td><span style="font-size: 13px; color: var(--text-muted);">{{ $minuta->created_at->diffForHumans() }}</span></td>
                        <td>
                            <div style="font-size: 13.5px; font-weight: 500; color: #1E293B;">
                                Menambahkan Akta <b>#{{ $minuta->no_minuta }}</b>
                            </div>
                            <div style="font-size: 11px; color: var(--primary);">
                                @if($minuta->bast_id)
                                    BAST #{{ $minuta->bast_id }} - {{ $minuta->bast->kc_btn ?? 'KC BTN' }}
                                @else
                                    Tanpa BAST
                                @endif
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 13px; font-weight: 600; color: #475569;">{{ $minuta->user->name ?? 'Staff' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center" style="padding: 40px; color: var(--text-muted);">
                            <i class='bx bx-info-circle' style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                            Belum ada aktivitas terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- System Status -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Status Sistem</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Versi Aplikasi</div>
            <div class="detail-value">v1.0.0-stable</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Database</div>
            <div class="detail-value text-success"><i class='bx bxs-circle' style="font-size: 10px;"></i> Connected</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Server Time</div>
            <div class="detail-value">{{ now()->format('d M Y, H:i') }}</div>
        </div>
    </div>
</div>
@endsection
