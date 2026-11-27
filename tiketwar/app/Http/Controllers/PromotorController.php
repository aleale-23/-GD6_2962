<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
use Illuminate\View\View;

class PromotorController extends Controller
{
    public function index(): View
    {
        $daftarPromotor = Promotor::withCount('konsers')
            ->orderBy('nama')
            ->get();

        return view('promotor', compact('daftarPromotor'));
    }
}
