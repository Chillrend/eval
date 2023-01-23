<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\CandidatePres;
use App\Models\CandidateTes;
use App\Models\Criteria;
use Exception;
use Illuminate\Http\Request;

class FinishController extends Controller
{
    public function getTahun()
    {
        try {
            $list_tahun = Criteria::select('tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($list_tahun); $x++) {
                $list_tahun[$x] = $list_tahun[$x]['tahun'];
            }

            return response()->json([
                'tahun' => $list_tahun,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getPend()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $tahun = request('tahun');
            return response()->json([
                'pendidikan' => [
                    'D2', 'D3', 'S1', 'S2'
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getKolom()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
            ]);

            $tahun = request('tahun');
            $pendidikan = request('pendidikan');

            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_pres')->doesntExist()) {
                throw new Exception("Data Seleksi Prestasi Tidak Ditemukan", 1);
            } elseif (CandidatePres::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                throw new Exception("Pastikan Data Seleksi Prestasi Telah Melewati Tahap Filter", 1);
            } else {
                $pres = Criteria::query()
                    ->select('kolom')
                    ->where('tahun', intval($tahun))
                    ->where('table', 'candidates_pres')->first();
                $pres = $pres->kolom;
            }

            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_tes')->doesntExist()) {
                throw new Exception("Data Seleksi Tes Tidak Ditemukan", 1);
            } elseif (CandidateTes::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                throw new Exception("Pastikan Data Seleksi Tes Telah Melewati Tahap Filter", 1);
            } else {
                $tes = Criteria::query()
                    ->select('kolom')
                    ->where('tahun', intval($tahun))
                    ->where('table', 'candidates_tes')->first();
                $tes = $tes->kolom;
            }
            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_mand')->doesntExist()) {
                throw new Exception("Data Seleksi Mandiri Tidak Ditemukan", 1);
            } elseif (CandidateMand::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                throw new Exception("Pastikan Data Seleksi Mandiri Telah Melewati Tahap Filter", 1);
            } else {
                $mand = Criteria::query()
                    ->select('kolom')
                    ->where('tahun', intval($tahun))
                    ->where('table', 'candidates_mand')->first();
                $mand = $mand->kolom;
            }
            return response()->json([
                'pres' => $pres,
                'tes' => $tes,
                'mand' => $mand,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getPres()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'id' => 'required',
                'nama' => 'required',
                'jurusan' => 'required',
                'alamat' => 'required',
            ]);
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $kolom = [request('id'), request('nama'), request('jurusan'), request('alamat')];

            $data = CandidatePres::query()->where('periode', $tahun)->get();
            dd($data);
            return response()->json([
                'pendidikan' => [
                    'D2', 'D3', 'S1', 'S2'
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
