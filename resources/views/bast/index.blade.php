@extends('layouts.app')

@section('title', 'Data BAST')
@section('page_title', 'Data BAST')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar BAST</h2>
        <a href="{{ route('bast.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Tambah BAST
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipe BAST</th>
                    <th>Petugas Pembuat</th>
                    <th>Tgl Diserahkan</th>
                    <th>Tgl Diterima</th>
                    <th>Status</th>
                    <th>KC BTN</th>
                    <th>Total Akta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($basts as $bast)
                <tr>
                    <td>{{ $bast->id }}</td>
                    <td><span class="badge badge-info">{{ $bast->tipe_bast }}</span></td>
                    <td><span style="font-weight: 600; color: #475569;">{{ $bast->user->name ?? 'Staff' }}</span></td>
                    <td>{{ $bast->tgl_diserahkan }}</td>
                    <td>{{ $bast->tgl_diterima ?? '-' }}</td>
                    <td>
                        @if($bast->status == 'Selesai')
                            <span class="badge badge-success">{{ $bast->status }}</span>
                        @else
                            <span class="badge badge-warning">{{ $bast->status }}</span>
                        @endif
                    </td>
                    <td>{{ $bast->kc_btn }}</td>
                    <td>
                        <span class="badge badge-info">{{ $bast->minutas_count }} Akta</span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('bast.show', $bast->id) }}" class="btn btn-sm btn-secondary btn-icon" title="Lihat">
                                <i class='bx bx-show'></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('bast.edit', $bast->id) }}" class="btn btn-sm btn-primary btn-icon" title="Edit">
                                <i class='bx bx-edit'></i>
                            </a>
                            <form action="{{ route('bast.destroy', $bast->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus BAST ini?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Hapus">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: var(--text-muted)">
                        Belum ada data BAST.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
