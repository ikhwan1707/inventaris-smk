<?php

namespace App\Http\Controllers;

use App\Condition;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Condition::query();

        if ($request->filled('keyword')) {
            $query->where('nama_kondisi', 'like', '%' . $request->keyword . '%');
        }

        $data = $query->orderBy('nama_kondisi')
            ->paginate(20)
            ->appends($request->query());

        return view('kondisi.index', compact('data'));
    }

    public function create()
    {
        return view('kondisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:50|unique:conditions,nama_kondisi',
        ], [
            'nama_kondisi.required' => 'Nama kondisi wajib diisi.',
            'nama_kondisi.unique'   => 'Nama kondisi sudah ada.',
        ]);

        Condition::create($request->only('nama_kondisi'));

        return redirect()->route('kondisi.index')
            ->with('success', 'Data kondisi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = Condition::findOrFail($id);
        return view('kondisi.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Condition::findOrFail($id);
        return view('kondisi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Condition::findOrFail($id);

        $request->validate([
            'nama_kondisi' => 'required|string|max:50|unique:conditions,nama_kondisi,' . $id,
        ]);

        $data->update($request->only('nama_kondisi'));

        return redirect()->route('kondisi.index')
            ->with('success', 'Data kondisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Condition::findOrFail($id);

        if ($data->items()->count() > 0) {
            return redirect()->route('kondisi.index')
                ->with('error', 'Kondisi tidak bisa dihapus karena masih digunakan oleh data barang.');
        }

        $data->delete();

        return redirect()->route('kondisi.index')
            ->with('success', 'Data kondisi berhasil dihapus.');
    }
}