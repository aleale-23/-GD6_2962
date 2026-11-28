<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PesananResource;
use App\Models\Konser;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan admin
    public function index()
    {
        return PesananResource::collection(
            Pesanan::latest()->get()
        );
    }

    // Membuat pesanan baru
    public function store(Request $request, Konser $konser): JsonResponse
    {
        $data = $request->validate([
            'nama_pemesan' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $pesanan = DB::transaction(function () use ($konser, $data) {

            $terkunci = Konser::lockForUpdate()
                ->findOrFail($konser->id);

            if ($data['jumlah'] > $terkunci->sisa) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Sisa tiket hanya ' . $terkunci->sisa . '.',
                ]);
            }

            $pesanan = Pesanan::create([
                'konser_id' => $terkunci->id,
                'nama_pemesan' => $data['nama_pemesan'],
                'email' => $data['email'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $terkunci->harga,
                'total' => $terkunci->harga * $data['jumlah'],
                'status' => Pesanan::MENUNGGU_BAYAR,
            ]);

            $terkunci->decrement('sisa', $data['jumlah']);

            return $pesanan;
        });

        return (new PesananResource($pesanan))
            ->response()
            ->setStatusCode(201);
    }

    // Mengubah status pesanan menjadi lunas
    public function bayar(Pesanan $pesanan)
    {
        return DB::transaction(function () use ($pesanan) {

            $terkunci = Pesanan::lockForUpdate()
                ->findOrFail($pesanan->id);

            if ($terkunci->status !== 'menunggu_bayar') {
                return response()->json([
                    'message' => 'Pesanan hanya dapat dibayar jika berstatus menunggu_bayar.',
                ], 409);
            }

            $terkunci->update([
                'status' => 'lunas',
            ]);

            return new PesananResource($terkunci);
        });
    }

    // Membatalkan pesanan dan mengembalikan stok
    public function batal(Pesanan $pesanan)
    {
        return DB::transaction(function () use ($pesanan) {

            $terkunci = Pesanan::lockForUpdate()
                ->findOrFail($pesanan->id);

            if ($terkunci->status !== 'menunggu_bayar') {
                return response()->json([
                    'message' => 'Pesanan hanya dapat dibatalkan jika berstatus menunggu_bayar.',
                ], 409);
            }

            $konser = Konser::lockForUpdate()
                ->findOrFail($terkunci->konser_id);

            $terkunci->update([
                'status' => 'batal',
            ]);

            $konser->increment('sisa', $terkunci->jumlah);

            return new PesananResource($terkunci);
        });
    }
}