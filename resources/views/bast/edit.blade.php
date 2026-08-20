@extends('layouts.app')

@section('title', 'Edit BAST')
@section('page_title', 'Edit BAST')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-edit' style="color: var(--primary); font-size: 24px;"></i> Edit BAST #{{ $bast->id }}
        </h2>
        <a href="{{ route('bast.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <form action="{{ route('bast.update', $bast->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Hidden Author Field (Keeps Original/Updated ID) -->
        <input type="hidden" name="user_id" value="{{ old('user_id', $bast->user_id) }}">

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kantor Cabang (KC) BTN</label>
                <input type="text" name="kc_btn" class="form-control" placeholder="Contoh: KC Jakarta Harmoni" value="{{ old('kc_btn', $bast->kc_btn) }}" required>
                @error('kc_btn') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tipe BAST</label>
                <select name="tipe_bast" class="form-control" required>
                    <option value="BAST Salinan" {{ old('tipe_bast', $bast->tipe_bast) == 'BAST Salinan' ? 'selected' : '' }}>BAST Salinan</option>
                    <option value="Sertipikat" {{ old('tipe_bast', $bast->tipe_bast) == 'Sertipikat' ? 'selected' : '' }}>Sertipikat</option>
                    <option value="Salinan dan Sertipikat" {{ old('tipe_bast', $bast->tipe_bast) == 'Salinan dan Sertipikat' ? 'selected' : '' }}>Salinan dan Sertipikat</option>
                </select>
                @error('tipe_bast') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Status Dokumen</label>
                <select name="status" class="form-control" required>
                    <option value="Belum Selesai" {{ old('status', $bast->status) == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="Selesai" {{ old('status', $bast->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Diserahkan</label>
                <input type="date" name="tgl_diserahkan" class="form-control" value="{{ old('tgl_diserahkan', $bast->tgl_diserahkan) }}" required>
                @error('tgl_diserahkan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Tanggal Diterima</label>
                <input type="date" name="tgl_diterima" class="form-control" value="{{ old('tgl_diterima', $bast->tgl_diterima) }}">
                @error('tgl_diterima') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Keterangan / Catatan Tambahan</label>
            <textarea name="keterangan" class="form-control" placeholder="Tuliskan keterangan detail di sini..." rows="4">{{ old('keterangan', $bast->keterangan) }}</textarea>
            @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid var(--border); padding-top: 25px; margin-top: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-save'></i> Perbarui BAST
            </button>
        </div>
    </form>
</div>
@endsection
