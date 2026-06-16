<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'no_telepon'     => 'required|string|unique:customers,no_telepon|max:20',
            'alamat'         => 'nullable|string',
        ]);

        Customer::create($request->only('nama_pelanggan', 'email', 'no_telepon', 'alamat'));

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $customer   = Customer::with('orders')->findOrFail($id);
        $pointLogs  = $customer->pointLogs()->latest()->get();
        return view('customers.show', compact('customer', 'pointLogs'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'no_telepon'     => 'required|string|unique:customers,no_telepon,' . $customer->id . '|max:20',
            'alamat'         => 'nullable|string',
        ]);

        $customer->update($request->only('nama_pelanggan', 'email', 'no_telepon', 'alamat'));

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}