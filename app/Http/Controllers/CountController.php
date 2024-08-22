<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('latihan.index');
    }

    public function jumlah()
    {
        $jumlah = 0;
        return view('latihan.jumlah', compact('jumlah'));
    }

    public function kurang()
    {
        $kurang = 0;
        return view('latihan.kurang', compact('kurang'));
    }

    public function kali()
    {
        $kali = 0;
        return view('latihan.kali', compact('kali'));
    }

    public function bagi()
    {
        $bagi = 0;
        return view('latihan.bagi', compact('bagi'));
    }

    public function storejumlah(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;

        $jumlah = $angka1 + $angka2;

        return view('latihan.jumlah', compact('jumlah'));
    }

    public function storekurang(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;

        $kurang = $angka1 - $angka2;

        return view('latihan.kurang', compact('kurang'));
    }

    public function storekali(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;

        $kali = $angka1 * $angka2;

        return view('latihan.kali', compact('kali'));
    }

    public function storebagi(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;

        $bagi = $angka1 / $angka2;

        return view('latihan.bagi', compact('bagi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
