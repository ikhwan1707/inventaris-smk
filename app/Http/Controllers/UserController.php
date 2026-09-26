<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%');
            });
        }

        $data = $query->orderBy('name')
            ->paginate(20)
            ->appends($request->query());

        return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('user.show', compact('data'));
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan user lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data->name  = $request->name;
        $data->email = $request->email;

        if ($request->filled('password')) {
            $data->password = Hash::make($request->password);
        }

        $data->save();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        if ($data->id == auth()->id()) {
            return redirect()->route('user.index')
                ->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $data->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}