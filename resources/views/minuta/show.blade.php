@extends('layouts.app')

@section('title', 'Detail Minuta')
@section('page_title', 'Detail Minuta')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title">Informasi Minuta #{{ $minuta->id }}</h2>
        <div class="flex gap-2">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('minuta.edit', $minuta->id) }}" class="btn btn-primary">
                <i class='bx bx-edit'></i> Edit
            </a>
            @endif
            <a href="{{ route('minuta.index') }}" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="grid-2">
        <div>
            <div class="detail-item">
                <div class="detail-label">No Minuta</div>
                <div class="detail-value" style="font-weight: 600; font-size: 18px; color: var(--primary-color);">
                    {{ $minuta->no_minuta }}
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Jenis Minuta</div>
                <div class="detail-value">
                    <span class="badge badge-info">{{ $minuta->jenis_minuta }}</span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Terkait BAST</div>
                <div class="detail-value">
                    @if($minuta->bast_id)
                        <a href="{{ route('bast.show', $minuta->bast_id) }}" style="font-weight: 600; text-decoration: none; color: var(--primary);">
                            BAST #{{ $minuta->bast_id }} - {{ $minuta->bast->kc_btn ?? 'KC BTN' }}
                        </a>
                    @else
                        <span class="text-muted" style="font-style: italic;">Tanpa BAST</span>
                    @endif
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Pembuat (User ID)</div>
                <div class="detail-value">{{ $minuta->user_id }}</div>
            </div>
        </div>
        
        <div>
            <div class="detail-item">
                <div class="detail-label">Tanggal Minuta</div>
                <div class="detail-value">{{ $minuta->tgl_minuta }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Nama Debitur</div>
                <div class="detail-value">{{ $minuta->nama_debitur }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Pejabat Bank</div>
                <div class="detail-value">{{ $minuta->pejabat_bank }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Developer</div>
                <div class="detail-value">{{ $minuta->developer }}</div>
            </div>
        </div>
    </div>
    
    <div class="mt-4 pt-4" style="border-top: 1px solid var(--border-color);">
        <div class="detail-item">
            <div class="detail-label">Note / Catatan</div>
            <div class="detail-value" style="background: rgba(243, 244, 246, 0.5); padding: 15px; border-radius: 8px; min-height: 80px;">
                {{ $minuta->note ?? 'Tidak ada catatan.' }}
            </div>
        </div>
    </div>
</div>
@endsection
