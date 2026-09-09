@extends('layouts.app')

@section('title', 'Riwayat BAST')
@section('page_title', 'Riwayat BAST')

@section('content')
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-history' style="color: var(--primary); font-size: 24px;"></i> Riwayat BAST
        </h2>
    </div>

    <!-- Filters & Search Bar -->
    <div style="background: #F8FAFC; border: 1.5px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 25px;">
        <form action="{{ route('bast.history') }}" method="GET" style="margin: 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; align-items: flex-end;">
                
                <!-- Search Input -->
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 11.5px; margin-bottom: 6px;">Pencarian Kata Kunci</label>
                    <div style="position: relative;">
                        <input type="text" name="search" class="form-control" placeholder="Cari KC BTN, Tipe, No. Akta..." value="{{ request('search') }}" style="padding-left: 35px; font-size: 13px; height: 38px;">
                        <i class='bx bx-search' style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px;"></i>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 11.5px; margin-bottom: 6px;">Status Dokumen</label>
                    <select name="status" class="form-control" style="font-size: 13px; height: 38px;">
                        <option value="">Semua Status</option>
                        <option value="Belum Selesai" {{ request('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Petugas Filter -->
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 11.5px; margin-bottom: 6px;">Petugas Pembuat</label>
                    <select name="user_id" class="form-control" style="font-size: 13px; height: 38px;">
                        <option value="">Semua Petugas</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 11.5px; margin-bottom: 6px;">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="font-size: 13px; height: 38px;">
                </div>

                <!-- End Date -->
                <div class="form-group" style="margin: 0;">
                    <label class="form-label" style="font-size: 11.5px; margin-bottom: 6px;">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="font-size: 13px; height: 38px;">
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; height: 38px; padding: 0 15px; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 6px; border-radius: 8px;">
                        <i class='bx bx-filter-alt'></i> Cari
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'user_id', 'start_date', 'end_date']))
                        <a href="{{ route('bast.history') }}" class="btn btn-secondary" style="height: 38px; padding: 0 12px; font-size: 13px; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: #E2E8F0; color: #475569; border: none; text-decoration: none;" title="Reset Filter">
                            <i class='bx bx-refresh' style="font-size: 18px;"></i>
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>
    
    <div class="table-responsive" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15%;">ID BAST</th>
                    <th style="width: 50%;">Perihal</th>
                    <th style="width: 20%;">Tanggal Diserahkan</th>
                    <th style="width: 15%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($basts as $bast)
                <tr>
                    <td>
                        <span style="font-weight: 700; color: var(--primary);">#{{ $bast->id }}</span>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1E293B; font-size: 14px;">
                            Penyerahan {{ $bast->minutas_count }} Akta Minuta
                        </div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                            Tipe BAST: <b>{{ $bast->tipe_bast }}</b> | Kantor BTN: <b>{{ $bast->kc_btn }}</b> | Petugas: <b>{{ $bast->user->name ?? 'Staff' }}</b>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 500; color: #475569;">
                            {{ date('d-m-Y', strtotime($bast->tgl_diserahkan)) }}
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="flex gap-2" style="justify-content: center;">
                            <a href="{{ route('bast.show', $bast->id) }}" class="btn btn-sm btn-icon" style="background-color: #b9b5b545 !important; color: black !important; border: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);" title="Lihat Detail BAST">
                                <i class='bx bx-show'></i>
                            </a>
                            <a href="{{ route('bast.export', $bast->id) }}" class="btn btn-sm btn-icon" style="background-color: #2563EB !important; color: white !important; border: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);" title="Cetak via Word">
                                <i class='bx bx-file-blank'></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted); font-style: italic;">
                        <i class='bx bx-info-circle' style="font-size: 28px; margin-bottom: 10px; display: block; color: var(--primary);"></i>
                        Tidak ditemukan data riwayat BAST yang cocok dengan kriteria pencarian Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
