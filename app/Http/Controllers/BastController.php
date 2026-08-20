<?php

namespace App\Http\Controllers;

use App\Models\Bast;
use App\Models\Minuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BastController extends Controller
{
    public function index()
    {
        $basts = Bast::with(['user'])->withCount('minutas')->get();

        return view('bast.index', compact('basts'));
    }

    public function history(Request $request)
    {
        $query = Bast::with(['user'])->withCount('minutas');

        // Apply Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('kc_btn', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('tipe_bast', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('minutas', function ($mq) use ($search) {
                      $mq->where('no_minuta', 'like', "%{$search}%")
                        ->orWhere('nama_debitur', 'like', "%{$search}%")
                        ->orWhere('pejabat_bank', 'like', "%{$search}%")
                        ->orWhere('developer', 'like', "%{$search}%");
                  });
            });
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply User Filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Apply Date Filters
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_diserahkan', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_diserahkan', '<=', $request->input('end_date'));
        }

        $basts = $query->latest('tgl_diserahkan')->get();
        $users = \App\Models\User::all(); // For dropdown

        return view('bast.history', compact('basts', 'users'));
    }

    public function create()
    {
        return view('bast.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tipe_bast' => 'required|string|in:BAST Salinan,Minuta,Sertipikat,Salinan dan Sertipikat',
            'tgl_diserahkan' => 'required|date',
            'tgl_diterima' => 'nullable|date',
            'status' => 'required|string',
            'kc_btn' => 'required|string',
            'keterangan' => 'nullable|string',
            'minutas' => 'nullable|array',
            'minutas.*.no_minuta' => 'required|string',
            'minutas.*.jenis_minuta' => 'required|string',
            'minutas.*.pejabat_bank' => 'required|string',
            'minutas.*.nama_debitur' => 'required|string',
            'minutas.*.developer' => 'required|string',
            'minutas.*.tgl_minuta' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bast = DB::transaction(function () use ($request) {
            $bast = Bast::create($request->all());

            $minutasData = $request->input('minutas', []);
            foreach ($minutasData as $minuta) {
                $bast->minutas()->create([
                    'user_id' => auth()->id(),
                    'no_minuta' => $minuta['no_minuta'],
                    'jenis_minuta' => $minuta['jenis_minuta'],
                    'pejabat_bank' => $minuta['pejabat_bank'],
                    'nama_debitur' => $minuta['nama_debitur'],
                    'developer' => $minuta['developer'],
                    'tgl_minuta' => $minuta['tgl_minuta'],
                ]);
            }

            return $bast;
        });

        $count = count($request->input('minutas', []));
        $msg = 'BAST berhasil disimpan' . ($count > 0 ? " beserta $count akta minuta terlampir!" : '!');
        return redirect()->route('bast.show', $bast->id)->with('success', $msg);
    }

    public function show(Bast $bast)
    {
        $minutas = $bast->minutas;

        return view('bast.show', compact('bast', 'minutas'));
    }

    public function edit(Bast $bast)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        return view('bast.edit', compact('bast'));
    }

    public function update(Request $request, Bast $bast)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tipe_bast' => 'required|string|in:BAST Salinan,Minuta,Sertipikat,Salinan dan Sertipikat',
            'tgl_diserahkan' => 'required|date',
            'tgl_diterima' => 'nullable|date',
            'status' => 'required|string',
            'kc_btn' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bast->update($request->all());

        return redirect()->route('bast.index')->with('success', 'BAST updated successfully.');
    }

    public function destroy(Bast $bast)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        
        $bast->delete();

        return redirect()->route('bast.index')->with('success', 'BAST deleted successfully.');
    }

    public function export($id)
    {
        $bast = Bast::with(['minutas', 'user'])->findOrFail($id);

        $fileName = 'BAST_#' . $bast->id . '_' . str_replace(' ', '_', $bast->kc_btn) . '.xls';

        // Headers to download Excel file
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        // Build premium styled HTML Excel sheet
        echo "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Laporan BAST</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                body { font-family: 'Segoe UI', Arial, sans-serif; }
                .title { font-size: 16pt; font-weight: bold; text-align: center; color: #1E293B; }
                .subtitle { font-size: 10pt; text-align: center; color: #64748B; margin-bottom: 20px; }
                .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
                .meta-table td { padding: 6px; font-size: 10pt; color: #334155; }
                .meta-label { font-weight: bold; width: 180px; }
                .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                .data-table th { background-color: #4F46E5; color: #ffffff; font-weight: bold; font-size: 10pt; padding: 10px; border: 1px solid #CBD5E1; text-align: left; }
                .data-table td { font-size: 9.5pt; padding: 8px 10px; border: 1px solid #E2E8F0; color: #1E293B; }
                .badge-success { background-color: #DEF7EC; color: #03543F; font-weight: bold; padding: 3px 8px; border-radius: 4px; }
                .badge-warning { background-color: #FEF08A; color: #713F12; font-weight: bold; padding: 3px 8px; border-radius: 4px; }
            </style>
        </head>
        <body>
            <div class='title'>BERITA ACARA SERAH TERIMA (BAST)</div>
            <div class='subtitle'>SISTEMY - SISTEM INFORMASI MINUTA NOTARIS</div>
            <br/>
            
            <table class='meta-table'>
                <tr>
                    <td class='meta-label'>ID BAST:</td>
                    <td>#" . $bast->id . "</td>
                    <td class='meta-label'>Tanggal Diserahkan:</td>
                    <td>" . date('d-m-Y', strtotime($bast->tgl_diserahkan)) . "</td>
                </tr>
                <tr>
                    <td class='meta-label'>Kantor Cabang BTN:</td>
                    <td>" . htmlspecialchars($bast->kc_btn) . "</td>
                    <td class='meta-label'>Tanggal Diterima:</td>
                    <td>" . ($bast->tgl_diterima ? date('d-m-Y', strtotime($bast->tgl_diterima)) : 'Belum Diterima') . "</td>
                </tr>
                <tr>
                    <td class='meta-label'>Status Dokumen:</td>
                    <td>
                        <span class='" . ($bast->status == 'Selesai' ? 'badge-success' : 'badge-warning') . "'>
                            " . strtoupper($bast->status) . "
                        </span>
                    </td>
                    <td class='meta-label'>Petugas Pembuat:</td>
                    <td>" . htmlspecialchars($bast->user->name ?? 'Staff') . "</td>
                </tr>
                <tr>
                    <td class='meta-label'>Tipe BAST:</td>
                    <td>" . htmlspecialchars($bast->tipe_bast) . "</td>
                    <td class='meta-label'>Keterangan:</td>
                    <td>" . htmlspecialchars($bast->keterangan ?? '-') . "</td>
                </tr>
            </table>

            <div style='font-size: 11pt; font-weight: bold; color: #1E293B; border-bottom: 2px solid #4F46E5; padding-bottom: 5px; margin-top: 15px;'>
                DAFTAR AKTA MINUTA YANG TERLAMPIR
            </div>

            <table class='data-table'>
                <thead>
                    <tr>
                        <th style='width: 5%;'>No</th>
                        <th style='width: 20%;'>Nomor Akta</th>
                        <th style='width: 20%;'>Judul Akta / Jenis Minuta</th>
                        <th style='width: 15%;'>Pejabat Bank</th>
                        <th style='width: 15%;'>Nama Debitur</th>
                        <th style='width: 15%;'>Developer</th>
                        <th style='width: 10%;'>Tanggal Akta</th>
                    </tr>
                </thead>
                <tbody>";

        $no = 1;
        foreach ($bast->minutas as $minuta) {
            echo "
                    <tr>
                        <td style='text-align: center;'>" . $no++ . "</td>
                        <td>" . htmlspecialchars($minuta->no_minuta) . "</td>
                        <td>" . htmlspecialchars($minuta->jenis_minuta) . "</td>
                        <td>" . htmlspecialchars($minuta->pejabat_bank) . "</td>
                        <td>" . htmlspecialchars($minuta->nama_debitur) . "</td>
                        <td>" . htmlspecialchars($minuta->developer) . "</td>
                        <td style='text-align: center;'>" . date('d-m-Y', strtotime($minuta->tgl_minuta)) . "</td>
                    </tr>";
        }

        if ($bast->minutas->isEmpty()) {
            echo "
                    <tr>
                        <td colspan='7' style='text-align: center; color: #64748B; font-style: italic; padding: 20px;'>
                            Belum ada akta minuta yang dilampirkan pada BAST ini.
                        </td>
                    </tr>";
        }

        echo "
                </tbody>
            </table>
            <br/><br/>
            <table style='width: 100%; font-size: 10pt; margin-top: 30px;'>
                <tr>
                    <td style='width: 50%; text-align: center;'>
                        Diserahkan Oleh,<br/><br/><br/><br/>
                        <b>( _______________________ )</b><br/>
                        Petugas Notaris
                    </td>
                    <td style='width: 50%; text-align: center;'>
                        Diterima Oleh,<br/><br/><br/><br/>
                        <b>( _______________________ )</b><br/>
                        Pejabat Kantor Cabang BTN
                    </td>
                </tr>
            </table>
        </body>
        </html>";
        exit;
    }
}
