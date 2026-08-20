@extends('layouts.app')

@section('title', 'Detail BAST')
@section('page_title', 'Detail BAST')

@section('content')
<div class="card mb-4">
    <div class="card-header" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-info-circle' style="color: var(--primary); font-size: 24px;"></i> Informasi BAST #{{ $bast->id }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('bast.export', $bast->id) }}" class="btn btn-success">
                <i class='bx bx-file-blank'></i> Cetak via Excel
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('bast.edit', $bast->id) }}" class="btn btn-primary">
                <i class='bx bx-edit'></i> Edit
            </a>
            @endif
            <a href="{{ route('bast.index') }}" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="grid-2">
        <div>
            <div class="detail-item">
                <div class="detail-label">Status BAST</div>
                <div class="detail-value">
                    @if($bast->status == 'Selesai')
                        <span class="badge badge-success">{{ $bast->status }}</span>
                    @else
                        <span class="badge badge-warning">{{ $bast->status }}</span>
                    @endif
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Tipe BAST</div>
                <div class="detail-value"><span class="badge badge-info">{{ $bast->tipe_bast }}</span></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">KC BTN</div>
                <div class="detail-value">{{ $bast->kc_btn }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Petugas Pembuat</div>
                <div class="detail-value">{{ $bast->user->name ?? 'Staff' }}</div>
            </div>
        </div>
        
        <div>
            <div class="detail-item">
                <div class="detail-label">Tanggal Diserahkan</div>
                <div class="detail-value">{{ $bast->tgl_diserahkan }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Tanggal Diterima</div>
                <div class="detail-value">{{ $bast->tgl_diterima ?? 'Belum diterima' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Keterangan</div>
                <div class="detail-value">{{ $bast->keterangan ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Item Minuta yang Terkait ({{ $minutas->count() }})</h2>
        <a href="{{ route('minuta.create') }}" class="btn btn-primary btn-sm">
            <i class='bx bx-plus'></i> Tambah Minuta
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No Minuta</th>
                    <th>Jenis Minuta</th>
                    <th>Nama Debitur</th>
                    <th>Pejabat Bank</th>
                    <th>Developer</th>
                    <th>Tgl Minuta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($minutas as $minuta)
                <tr>
                    <td>{{ $minuta->no_minuta }}</td>
                    <td><span class="badge badge-info">{{ $minuta->jenis_minuta }}</span></td>
                    <td>{{ $minuta->nama_debitur }}</td>
                    <td>{{ $minuta->pejabat_bank }}</td>
                    <td>{{ $minuta->developer }}</td>
                    <td>{{ $minuta->tgl_minuta }}</td>
                    <td>
                        <a href="{{ route('minuta.show', $minuta->id) }}" class="btn btn-sm btn-secondary btn-icon" title="Lihat">
                            <i class='bx bx-show'></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-muted)">
                        Belum ada minuta yang terhubung dengan BAST ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
