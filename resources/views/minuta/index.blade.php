@extends('layouts.app')

@section('title', 'Data Minuta')
@section('page_title', 'Data Minuta')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Data Minuta</h2>
        <a href="{{ route('minuta.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Tambah Minuta
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No Minuta</th>
                    <th>BAST ID</th>
                    <th>Jenis Minuta</th>
                    <th>Pejabat Bank</th>
                    <th>Nama Debitur</th>
                    <th>Tgl Minuta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($minutas as $minuta)
                <tr>
                    <td>{{ $minuta->id }}</td>
                    <td><span style="font-weight: 600">{{ $minuta->no_minuta }}</span></td>
                    <td>
                        @if($minuta->bast_id)
                            <a href="{{ route('bast.show', $minuta->bast_id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                #{{ $minuta->bast_id }}
                            </a>
                        @else
                            <span class="text-muted" style="font-size: 12px; font-style: italic;">Tanpa BAST</span>
                        @endif
                    </td>
                    <td><span class="badge badge-info">{{ $minuta->jenis_minuta }}</span></td>
                    <td>{{ $minuta->pejabat_bank }}</td>
                    <td>{{ $minuta->nama_debitur }}</td>
                    <td>{{ $minuta->tgl_minuta }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('minuta.show', $minuta->id) }}" class="btn btn-sm btn-secondary btn-icon" title="Lihat">
                                <i class='bx bx-show'></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('minuta.edit', $minuta->id) }}" class="btn btn-sm btn-primary btn-icon" title="Edit">
                                <i class='bx bx-edit'></i>
                            </a>
                            <form action="{{ route('minuta.destroy', $minuta->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Minuta ini?');" style="display:inline-block;">
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
                    <td colspan="8" style="text-align: center; padding: 30px; color: var(--text-muted)">
                        Belum ada data Minuta.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
