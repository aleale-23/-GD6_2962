<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AkunController extends Controller
{
    // Menampilkan halaman ganti kata sandi
    public function edit(): View
    {
        return view('akun.password');
    }

    // Memproses perubahan kata sandi
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => [
                'required',
                'current_password'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ], [
            'current_password.required' =>
                'Kata sandi saat ini wajib diisi.',

            'current_password.current_password' =>
                'Kata sandi saat ini salah.',

            'password.required' =>
                'Kata sandi baru wajib diisi.',

            'password.min' =>
                'Kata sandi baru minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi kata sandi tidak cocok.',
        ]);

        $request->user()->update([
            'password' => $data['password'],
        ]);

        return redirect()
            ->route('pesanan.index')
            ->with('status', 'Kata sandi berhasil diperbarui.');
    }
}