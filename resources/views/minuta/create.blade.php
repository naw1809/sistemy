@extends('layouts.app')

@section('title', 'Tambah Data Minuta')
@section('page_title', 'Tambah Data Minuta')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-plus-circle' style="color: var(--primary); font-size: 24px;"></i> Form Tambah Data Minuta
        </h2>
        <a href="{{ route('minuta.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <form action="{{ route('minuta.store') }}" method="POST">
        @csrf
        
        <!-- Hidden Creator Field (Authenticated User) -->
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">


        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Nomor Akta (No Minuta)</label>
                <input type="text" name="no_minuta" class="form-control" placeholder="Tuliskan nomor akta..." value="{{ old('no_minuta') }}" required>
                @error('no_minuta') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Judul Akta (Jenis Minuta)</label>
                <input type="text" name="jenis_minuta" class="form-control" placeholder="Tuliskan judul/jenis akta..." value="{{ old('jenis_minuta') }}" required>
                @error('jenis_minuta') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Pejabat Bank</label>
                <input type="text" name="pejabat_bank" class="form-control" placeholder="Nama pejabat bank..." value="{{ old('pejabat_bank') }}" required>
                @error('pejabat_bank') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Debitur</label>
                <input type="text" name="nama_debitur" class="form-control" placeholder="Nama lengkap debitur..." value="{{ old('nama_debitur') }}" required>
                @error('nama_debitur') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Developer</label>
                <input type="text" name="developer" class="form-control" placeholder="Nama developer perumahan..." value="{{ old('developer') }}" required>
                @error('developer') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Akta (Tanggal Minuta)</label>
                <input type="date" name="tgl_minuta" class="form-control" value="{{ old('tgl_minuta') }}" required>
                @error('tgl_minuta') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Catatan / Note</label>
            <textarea name="note" class="form-control" placeholder="Tuliskan catatan tambahan di sini..." rows="3">{{ old('note') }}</textarea>
            @error('note') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid var(--border); padding-top: 25px; margin-top: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-save'></i> Simpan Data Minuta
            </button>
        </div>
    </form>
</div>
@endsection
