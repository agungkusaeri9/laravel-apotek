<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $items = Unit::orderBy('nama', 'ASC')->get();
        return view('dashboard.unit.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('dashboard.unit.create');
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Unit::create($data);
            DB::commit();
            return redirect()->route('unit.index')
                ->with('success', 'Data Berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function edit($id)
    {
        $item = Unit::findOrFail($id);
        return view('dashboard.unit.edit', [
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            $item = Unit::findOrFail($id);
            $item->update($data);
            DB::commit();
            return redirect()->route('unit.index')
                ->with('success', 'Data Berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = Unit::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('unit.index')
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
