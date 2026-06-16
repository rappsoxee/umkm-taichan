<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        $jumlahMeja = $request->query('meja', 10);
        $baseUrl = config('app.url') . '/menu?meja=';

        $qrcodes = [];
        for ($i = 1; $i <= $jumlahMeja; $i++) {
            $qrcodes[$i] = QrCode::format('svg')
                ->size(200)
                ->errorCorrection('H')
                ->generate($baseUrl . $i);
        }

        return view('qrcodes.index', compact('qrcodes', 'jumlahMeja'));
    }
}