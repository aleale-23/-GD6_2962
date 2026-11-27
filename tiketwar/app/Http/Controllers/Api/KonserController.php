<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KonserResource;
use App\Models\Konser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class KonserController extends Controller
{
    // Menampilkan semua konser dan filter berdasarkan kota
    public function index(Request $request): AnonymousResourceCollection
    {
        $daftarKonser = Konser::with('promotor')
            ->when($request->query('kota'), function ($query, $kota) {
                $query->where('kota', $kota);
            })
            ->orderBy('tanggal')
            ->get();

        return KonserResource::collection($daftarKonser);
    }

    // Menampilkan detail konser
    public function show(Konser $konser): KonserResource
    {
        return new KonserResource(
            $konser->load('promotor')
        );
    }

    // Aturan validasi tambah dan ubah konser
    private function aturan(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'sisa' => ['required', 'integer', 'min:0'],
            'tanggal' => ['required', 'date'],
            'promotor_id' => [
                'required',
                'integer',
                'exists:App\Models\Promotor,id'
            ],
        ];
    }

    // Menambah konser baru
    public function store(Request $request)
    {
        $data = $request->validate($this->aturan());

        $konser = Konser::create($data);

        return (new KonserResource($konser->load('promotor')))
            ->response()
            ->setStatusCode(201);
    }

    // Mengubah data konser
    public function update(Request $request, Konser $konser)
    {
        $data = $request->validate($this->aturan());

        $konser->update($data);

        return new KonserResource(
            $konser->load('promotor')
        );
    }

    // Menghapus konser
    public function destroy(Konser $konser)
    {
        if ($konser->pesanans()->exists()) {
            return response()->json([
                'message' => 'Konser tidak dapat dihapus karena sudah memiliki pesanan.'
            ], 409);
        }

        $konser->delete();

        return response()->noContent();
    }
}