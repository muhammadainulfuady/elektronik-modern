<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Dusun;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getKotas($id_provinsi)
    {
        $kotas = Kota::where('id_provinsi', $id_provinsi)
            ->select('id_kota', 'nama_kota')
            ->orderBy('nama_kota')
            ->get();
        return response()->json($kotas);
    }

    public function getKecamatans($id_kota)
    {
        $kecamatans = Kecamatan::where('id_kota', $id_kota)
            ->select('id_kecamatan', 'nama_kecamatan')
            ->orderBy('nama_kecamatan')
            ->get();
        return response()->json($kecamatans);
    }

    public function getDesas($id_kecamatan)
    {
        $desas = Desa::where('id_kecamatan', $id_kecamatan)
            ->select('id_desa', 'nama_desa')
            ->orderBy('nama_desa')
            ->get();
        return response()->json($desas);
    }

    public function getDusuns($id_desa)
    {
        $dusuns = Dusun::where('id_desa', $id_desa)
            ->select('id_dusun', 'nama_dusun')
            ->orderBy('nama_dusun')
            ->get();
        return response()->json($dusuns);
    }
}
