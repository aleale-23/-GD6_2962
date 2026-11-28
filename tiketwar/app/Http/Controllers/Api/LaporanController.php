<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;

class LaporanController extends Controller
{
    public function index(): JsonResponse
    {
        // Menghitung seluruh pesanan
        $jumlahPesanan = Pesanan::count();

        // Menghitung pendapatan dari pesanan lunas
        $totalPendapatan = Pesanan::where(
            'status',
            Pesanan::LUNAS
        )->sum('total');

        // Menghitung jumlah pesanan berdasarkan status
        $perStatus = Pesanan::selectRaw(
            'status, COUNT(*) as jumlah'
        )
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        return response()->json([
            'data' => [
                'jumlah_pesanan' => (int) $jumlahPesanan,
                'total_pendapatan' => (int) $totalPendapatan,
                'per_status' => [
                    'menunggu_bayar' => (int) $perStatus->get(
                        'menunggu_bayar', 0
                    ),
                    'lunas' => (int) $perStatus->get(
                        'lunas', 0
                    ),
                    'batal' => (int) $perStatus->get(
                        'batal', 0
                    ),
                ],
            ],
        ]);
    }
}