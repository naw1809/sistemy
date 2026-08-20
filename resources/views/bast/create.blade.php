@extends('layouts.app')

@section('title', 'Tambah BAST')
@section('page_title', 'Tambah BAST')

@section('content')
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-plus-circle' style="color: var(--primary); font-size: 24px;"></i> Form Tambah BAST
        </h2>
        <a href="{{ route('bast.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>

    <form action="{{ route('bast.store') }}" method="POST">
        @csrf
        
        <!-- Hidden Author Field (Authenticated User) -->
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kantor Cabang (KC) BTN</label>
                <input type="text" name="kc_btn" class="form-control" placeholder="Contoh: KC Jakarta Harmoni" value="{{ old('kc_btn') }}" required>
                @error('kc_btn') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tipe BAST</label>
                <select name="tipe_bast" class="form-control" required>
                    <option value="BAST Salinan" {{ old('tipe_bast') == 'BAST Salinan' ? 'selected' : '' }}>BAST Salinan</option>
                    <option value="BAST Minuta" {{ old('tipe_bast') == 'BAST Minuta' ? 'selected' : '' }}>BAST Minuta</option>
                    <option value="Sertipikat" {{ old('tipe_bast') == 'Sertipikat' ? 'selected' : '' }}>Sertipikat</option>
                    <option value="Salinan dan Sertipikat" {{ old('tipe_bast') == 'Salinan dan Sertipikat' ? 'selected' : '' }}>Salinan dan Sertipikat</option>
                </select>
                @error('tipe_bast') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Status Dokumen</label>
                <select name="status" class="form-control" required>
                    <option value="Belum Selesai" {{ old('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Diserahkan</label>
                <input type="date" name="tgl_diserahkan" class="form-control" value="{{ old('tgl_diserahkan') }}" required>
                @error('tgl_diserahkan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Tanggal Diterima (Opsional)</label>
                <input type="date" name="tgl_diterima" class="form-control" value="{{ old('tgl_diterima') }}">
                @error('tgl_diterima') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan / Catatan Tambahan</label>
                <textarea name="keterangan" class="form-control" placeholder="Tuliskan keterangan detail di sini..." rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Section: Daftar Akta Minuta (Dynamic Table) -->
        <div style="margin-top: 40px; margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px dashed var(--border); padding-bottom: 12px; margin-bottom: 15px;">
                <h3 style="font-size: 15px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bx-list-ul' style="color: var(--primary); font-size: 22px;"></i> Daftar Akta Minuta yang Diserahkan
                </h3>
                <button type="button" id="btn-add-minuta" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px; border-radius: 8px;">
                    <i class='bx bx-plus'></i> Tambah Akta
                </button>
            </div>

            <div class="table-responsive" style="border-radius: 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: var(--shadow-sm); width: 100%; max-width: 100%; display: block;">
                <table class="table table-dynamic" id="table-minutas" style="min-width: 680px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="min-width: 100px;">Nomor Akta *</th>
                            <th style="min-width: 110px;">Judul Akta *</th>
                            <th style="min-width: 110px;">Pejabat Bank *</th>
                            <th style="min-width: 110px;">Nama Debitur *</th>
                            <th style="min-width: 100px;">Developer *</th>
                            <th style="min-width: 105px;">Tgl Akta *</th>
                            <th style="width: 45px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="minutas-container">
                        <tr class="empty-row">
                            <td colspan="7" style="text-align: center; padding: 25px !important; color: var(--text-muted); font-style: italic;">
                                Belum ada akta minuta yang ditambahkan. Klik tombol "+ Tambah Akta" di atas.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid var(--border); padding-top: 25px; margin-top: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-save'></i> Simpan BAST
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('minutas-container');
    const btnAdd = document.getElementById('btn-add-minuta');
    let rowIndex = 0;

    function checkEmptyRow() {
        const rows = container.querySelectorAll('tr:not(.empty-row)');
        const emptyRow = container.querySelector('.empty-row');
        if (rows.length === 0) {
            if (!emptyRow) {
                const tr = document.createElement('tr');
                tr.className = 'empty-row';
                tr.innerHTML = `
                    <td colspan="7" style="text-align: center; padding: 25px !important; color: var(--text-muted); font-style: italic;">
                        Belum ada akta minuta yang ditambahkan. Klik tombol "+ Tambah Akta" di atas.
                    </td>
                `;
                container.appendChild(tr);
            }
        } else {
            if (emptyRow) {
                emptyRow.remove();
            }
        }
    }

    btnAdd.addEventListener('click', function () {
        // Hapus empty row jika ada
        const emptyRow = container.querySelector('.empty-row');
        if (emptyRow) emptyRow.remove();

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="minutas[${rowIndex}][no_minuta]" class="form-control form-control-sm" placeholder="No. Akta" required>
            </td>
            <td>
                <input type="text" name="minutas[${rowIndex}][jenis_minuta]" class="form-control form-control-sm" placeholder="Judul Akta" required>
            </td>
            <td>
                <input type="text" name="minutas[${rowIndex}][pejabat_bank]" class="form-control form-control-sm" placeholder="Pejabat Bank" required>
            </td>
            <td>
                <input type="text" name="minutas[${rowIndex}][nama_debitur]" class="form-control form-control-sm" placeholder="Nama Debitur" required>
            </td>
            <td>
                <input type="text" name="minutas[${rowIndex}][developer]" class="form-control form-control-sm" placeholder="Developer" required>
            </td>
            <td>
                <input type="date" name="minutas[${rowIndex}][tgl_minuta]" class="form-control form-control-sm" required>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn-danger-soft btn-remove-row" title="Hapus Akta">
                    <i class='bx bx-trash' style="font-size: 16px;"></i>
                </button>
            </td>
        `;
        container.appendChild(tr);
        rowIndex++;
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-row')) {
            const row = e.target.closest('tr');
            row.classList.add('row-fade-out');
            row.addEventListener('animationend', function() {
                row.remove();
                checkEmptyRow();
            });
        }
    });
});
</script>
@endpush
