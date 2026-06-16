<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    // Halaman pilih auth (login/register/guest)
    public function showAuth(Request $request)
    {
        $noMeja = $request->query('meja');
        if (!$noMeja) {
            return redirect('/menu');
        }
        return view('menu.auth', compact('noMeja'));
    }

    // Login customer pakai nama + no telepon
    public function login(Request $request)
    {
        $request->validate([
            'no_telepon' => 'required|string',
            'nama'       => 'required|string',
            'meja'       => 'required|string',
        ]);

        $customer = Customer::where('no_telepon', $request->no_telepon)
                            ->where('nama_pelanggan', $request->nama)
                            ->first();

        if (!$customer) {
            return back()->withErrors(['login' => 'Nama atau no. telepon tidak ditemukan.'])->withInput();
        }

        session([
            'customer_id'   => $customer->id,
            'customer_nama' => $customer->nama_pelanggan,
            'customer_poin' => $customer->poin,
            'no_meja'       => $request->meja,
        ]);

        return redirect("/menu?meja={$request->meja}");
    }

    // Register customer baru
    public function register(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20|unique:customers,no_telepon',
            'meja'       => 'required|string',
        ]);

        $customer = Customer::create([
            'nama_pelanggan' => $request->nama,
            'no_telepon'     => $request->no_telepon,
            'poin'           => 0,
        ]);

        session([
            'customer_id'   => $customer->id,
            'customer_nama' => $customer->nama_pelanggan,
            'customer_poin' => 0,
            'no_meja'       => $request->meja,
        ]);

        return redirect("/menu?meja={$request->meja}");
    }

    // Lanjut sebagai guest
    public function guest(Request $request)
    {
        $request->validate([
            'meja' => 'required|string',
        ]);

        // Hapus session customer kalau ada
        session()->forget(['customer_id', 'customer_nama', 'customer_poin']);
        session(['no_meja' => $request->meja]);

        return redirect("/menu?meja={$request->meja}");
    }

    // Logout customer
    public function logout(Request $request)
    {
        $meja = session('no_meja');
        session()->forget(['customer_id', 'customer_nama', 'customer_poin', 'no_meja']);
        return redirect($meja ? "/menu/auth?meja={$meja}" : '/menu');
    }
}