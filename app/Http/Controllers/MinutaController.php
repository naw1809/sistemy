<?php

namespace App\Http\Controllers;

use App\Models\Minuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MinutaController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengakses data minuta.');
        $minutas = Minuta::with('bast')->get();

        return view('minuta.index', compact('minutas'));
    }

    public function create()
    {
        return view('minuta.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bast_id' => 'nullable|exists:basts,id',
            'user_id' => 'required|exists:users,id',
            'no_minuta' => 'required|string',
            'jenis_minuta' => 'required|string',
            'pejabat_bank' => 'required|string',
            'nama_debitur' => 'required|string',
            'developer' => 'required|string',
            'tgl_minuta' => 'required|date',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Minuta::create($request->all());

        return redirect()->route('minuta.index')->with('success', 'Minuta created successfully.');
    }

    public function show(Minuta $minuta)
    {
        return view('minuta.show', compact('minuta'));
    }

    public function edit(Minuta $minuta)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        return view('minuta.edit', compact('minuta'));
    }

    public function update(Request $request, Minuta $minuta)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        
        $validator = Validator::make($request->all(), [
            'bast_id' => 'nullable|exists:basts,id',
            'user_id' => 'required|exists:users,id',
            'no_minuta' => 'required|string',
            'jenis_minuta' => 'required|string',
            'pejabat_bank' => 'required|string',
            'nama_debitur' => 'required|string',
            'developer' => 'required|string',
            'tgl_minuta' => 'required|date',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $minuta->update($request->all());

        return redirect()->route('minuta.index')->with('success', 'Minuta updated successfully.');
    }

    public function destroy(Minuta $minuta)
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang diizinkan untuk mengubah atau menghapus data.');
        
        $minuta->delete();

        return redirect()->route('minuta.index')->with('success', 'Minuta deleted successfully.');
    }
}
