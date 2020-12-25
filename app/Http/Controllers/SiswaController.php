<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Validator;
use App\Telepon;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa_list = Siswa::orderBy('nisn', 'desc')->paginate(5);
        $jumlah_siswa = Siswa::count();
        return view('siswa.index', compact('siswa_list', 'jumlah_siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nisn'          => 'required|string|size:4|unique:siswa,nisn',
            'nama_siswa'    => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'sometimes|nullable|numeric|
            digits_between:10,15|unique:telepon,nomor_telepon',
        ]);

        if ($validator->fails()) {
            return redirect('siswa/create')
                ->withInput()
                ->withErrors($validator);
        }

        $siswa = Siswa::create($input);

        if ($request->filled('nomor_telepon')) {
            $telepon = new Telepon;
            $telepon->nomor_telepon = $request->input('nomor_telepon');
            $siswa->telepon()->save($telepon);
        }

        return redirect('siswa');
    }
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        if (!empty($siswa->telepon->nomor_telepon)) {
            $siswa->nomor_telepon = $siswa->telepon->nomor_telepon;
        }

        return view('siswa.edit', compact('siswa'));
    }

    public function update($id, Request $request)
    {
        $siswa = Siswa::findOrFail($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'nisn'          => 'required|string|size:4|unique:siswa,nisn,' . $request->input('id'),
            'nama_siswa'    => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'sometimes|nullable|numeric|
            digits_between:10,15|unique:telepon,nomor_telepon,' . $request->input('id') . ',id_siswa',
        ]);

        if ($validator->fails()) {
            return redirect('siswa/' . $id . '/edit')->withInput()->withErrors($validator);
        }

        $siswa->update($request->all());

        //Update nomor telepon, jika sebelumnya sudah ada nomor telp.
        if ($siswa->telepon) {
            //Jika telp diisi, update.
            if ($request->filled('nomor_telepon')) {
                $telepon = $siswa->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
            // Jiks telp tidak diisi, hapus.
            else {
                $siswa->telepon()->delete();
            }
        }
        // Buat entry baru, jika sebelumnya tidak ada no telp.
        else {
            if ($request->filled('nomor_telepon')) {
                $telepon = new Telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
        }
        return redirect('siswa');
    }


    function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect('siswa');
    }

    public function tesCollection()
    {
        // $orang = [
        //     'ani',
        //     'budi',
        //     'cindy',
        //     'dedi',
        //     'frans'
        // ];

        // $collection = collect($orang)->map(function ($nama) {
        //     return ucwords($nama);
        // });

        //FIRST
        // $collection = Siswa::all()->first();

        //last
        //       $collection = Siswa::all()->last();

        //count
        // $collection = Siswa::all();
        // $jumlah = $collection->count();
        // return 'Jumlah Data :' . $jumlah;

        //take
        // $collection = Siswa::all()->take(3);
        // return $collection;

        //pluck
        // $collection = Siswa::all()->pluck('nama_siswa');
        // return $collection;

        //where
        // $collection = Siswa::all();
        // $collection = $collection->where('nisn', '1010');
        // return $collection;

        //wherein
        // $collection = Siswa::all();
        // $collection = $collection->whereIn('nisn', ['1001', '1005', '1010']);
        // return $collection;

        //toArray
        // $collection = Siswa::select('nisn', 'nama_siswa')->take(3)->get();
        // $koleksi = $collection->toArray();
        // foreach ($koleksi as $siswa) {
        //     echo $siswa['nisn'] . ' - ' . $siswa['nama_siswa'] . '<br>';
        // }

        //toJson
        $data = [
            ['nisn' => '1001', 'nama_siswa' => 'Agus'],
            ['nisn' => '1002', 'nama_siswa' => 'Budi'],
            ['nisn' => '1003', 'nama_siswa' => 'Clara']
        ];
        $collection = collect($data);
        $collection->toJson();
        return $collection;
    }

    public function dateMutator()
    {
        $siswa = Siswa::findOrFail(12);
        $nama = $siswa->nama_siswa;
        $tanggal_lahir = $siswa->tanggal_lahir->format('d-m-Y');
        $ulang_tahun = $siswa->tanggal_lahir->addYears(30)->format('d-m-Y');
        return "Siswa {$nama} lahir pada {$tanggal_lahir}.<br>
        Ulang tahun ke-30 akan jatuh pada {$ulang_tahun}.";
    }
}
