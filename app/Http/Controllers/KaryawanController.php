<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\KaryawanResource;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_induk' => 'required|unique:karyawans|max:255',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('karyawan.create')
                ->withErrors($validator)
                ->withInput();
        }

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karyawan = Karyawan::find($id);

        if (is_null($karyawan)) {
            return redirect()->route('karyawan.index')->with('error', 'Karyawan tidak ditemukan!');
        }

        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('karyawans.edit',compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_induk' => 'required|max:255',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('karyawan.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $karyawan = Karyawan::find($id);
        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = Karyawan::find($id);

        if (is_null($karyawan)) {
            return redirect()->route('karyawan.index')->with('error', 'ID tidak ditemukan!');
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
    public function showSisaCutiWeb()
    {
        $response = Http::get('http://localhost:8000/api/sisacuti');
        $karyawan = $response->json();

        return view('sisacuti', ['data' => $karyawan]);
    }

}
