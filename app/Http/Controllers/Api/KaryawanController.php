<?php

namespace App\Http\Controllers\Api;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Karyawan::all();
        return response()->json([
            'status' => true,
            'message' => 'Data karyawan berhasil diambil',
            'data' => Karyawan::latest()->get(),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //     // Validasi data yang dikirim
    //     $input = $request->all();
    //     //validasi input
    // // Validasi input
    // $validator = Validator::make($input, [
    //     'nomor_induk' => 'required|unique:karyawans|max:255',
    //     'nama' => 'required|max:255',
    //     'alamat' => 'required|max:255',
    //     'tanggal_lahir' => 'required|date',
    //     'tanggal_bergabung' => 'required|date',
    // ]);
    // // Jika validasi gagal, kembalikan pesan error
    // if ($validator->fails()) {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Validasi gagal',
    //         'errors' => $validator->errors(),
    //     ], 422);
    // }
        $datakaryawan = new Karyawan;

        $rules = [
            'nomor_induk' => 'required|max:255',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>"Data tidak lengkap",
                'data' => $validator->errors()
            ]);
        }


        $datakaryawan->nomor_induk = $request->nomor_induk;
        $datakaryawan->nama = $request->nama;
        $datakaryawan->alamat = $request->alamat;
        $datakaryawan->tanggal_lahir = $request->tanggal_lahir;
        $datakaryawan->tanggal_bergabung = $request->tanggal_bergabung;

        $post = $datakaryawan->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karyawan = Karyawan::find($id);
        if (is_null($karyawan)) {
            return response()->json(['status' => false,'message'=>"Data karyawan tidak ditemukan",]
            ,404);
        }

        return response()->json([
            "status"=>true,
            "message"=>"Data karyawan ditemukan",
            "data"=>$karyawan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'nomor_induk' => 'required|max:255',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Temukan objek Karyawan berdasarkan ID
        $karyawan = Karyawan::find($id);

        // Jika Karyawan tidak ditemukan, kembalikan pesan error
        if (is_null($karyawan)) {
            return response()->json([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan!',
            ], 404);
        }

        // Update data Karyawan
        $karyawan->update($input);

        // Kembalikan respons sukses
        return response()->json([
            'status' => true,
            'message' => 'Karyawan berhasil diupdate!',
            'data' => new KaryawanResource($karyawan),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->delete();

            return $this->handleResponse([
                'deleted_id' => $id,
                'message' => 'Karyawan berhasil dihapus!',
            ], 'Karyawan berhasil dihapus!');
        } catch (\Exception $e) {
            return $this->handleError('Gagal menghapus karyawan. ' . $e->getMessage());
        }
    }

    public function tigakaryawanpertama()
    {
        $karyawans = Karyawan::orderBy('tanggal_bergabung')->take(3)->get();
        return response()->json($karyawans);
    }

    public function CutiKaryawan()
    {
        $karyawans = Karyawan::has('cutis')->get();

        return response()->json($karyawans);
    }

    public function sisaCutiKaryawan()
    {
        $karyawans = Karyawan::with('cutis')->get();

        $karyawans->map(function ($karyawan) {
            $totalCuti = $karyawan->cutis ? $karyawan->cutis->sum('lama_cuti') : 0;
            $sisaCuti = 12 - $totalCuti;
            $karyawan->sisa_cuti = $sisaCuti;
            return $karyawan;
        });

        $data = $karyawans->map(function ($karyawan) {
            return [
                'nomor_induk' => $karyawan->nomor_induk,
                'nama' => $karyawan->nama,
                'sisa_cuti' => $karyawan->sisa_cuti,
            ];
        });

        return response()->json($data);
    }

}
