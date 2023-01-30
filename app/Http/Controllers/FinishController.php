<?php

namespace App\Http\Controllers;

use App\Exports\CandidatesExport;
use App\Models\CandidateMand;
use App\Models\CandidatePres;
use App\Models\CandidateTes;
use App\Models\Criteria;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

            //PENCARIAN PRESTASI
            //Cek Keberadaan Data
            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_pres')->doesntExist()) {
                throw new Exception("Data Seleksi Prestasi Tidak Ditemukan", 1);
            } elseif (CandidatePres::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                //Cek Keberadaan Data Filter
                throw new Exception("Pastikan Data Seleksi Prestasi Telah Melewati Tahap Filter", 1);
            } elseif (
                CandidatePres::query()->where('periode', intval($tahun))->where('status', 'done')->exists() &&
                Criteria::query()->where('tahun', intval($tahun))->where('table', 'finish_candidates_pres')->exists()
            ) {
                //Cek Keberadaan Data Finish
                $candidates = CandidatePres::query()->where('periode', intval($tahun))->where('status', 'done')->get();
                $criteria = Criteria::query()->select('kolom')->where('tahun', intval($tahun))->where('table', 'finish_candidates_pres')->first();
                $pres = [
                    'candidate' => $candidates,
                    'kolom' => $criteria->kolom,
                ];
            } else {
                $pres = Criteria::query()
                    ->select('kolom')
                    ->where('tahun', intval($tahun))
                    ->where('table', 'candidates_pres')->first();
                $pres = $pres->kolom;
            }

            //PENCARIAN TES
            //Cek Keberadaan Data
            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_tes')->doesntExist()) {
                throw new Exception("Data Seleksi Tes Tidak Ditemukan", 1);
            } elseif (CandidateTes::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                //Cek Keberadaan Data Filter
                throw new Exception("Pastikan Data Seleksi Tes Telah Melewati Tahap Filter", 1);
            } elseif (
                CandidateTes::query()->where('periode', intval($tahun))->where('status', 'done')->exists() &&
                Criteria::query()->where('tahun', intval($tahun))->where('table', 'finish_candidates_tes')->exists()
            ) {
                //Cek Keberadaan Data Finish
                $candidates = CandidateTes::query()->where('periode', intval($tahun))->where('status', 'done')->get();
                $criteria = Criteria::query()->select('kolom')->where('tahun', intval($tahun))->where('table', 'finish_candidates_tes')->first();
                $tes = [
                    'candidate' => $candidates,
                    'kolom' => $criteria->kolom,
                ];
            } else {
                $tes = Criteria::query()
                    ->select('kolom')
                    ->where('tahun', intval($tahun))
                    ->where('table', 'candidates_tes')->first();
                $tes = $tes->kolom;
            }

            //PENCARIAN MANDIRI
            //Cek Keberadaan Data
            if (Criteria::query()->where('tahun', intval($tahun))->where('table', 'candidates_mand')->doesntExist()) {
                throw new Exception("Data Seleksi Mandiri Tidak Ditemukan", 1);
            } elseif (CandidateMand::query()->where('periode', intval($tahun))->where('status', 'filtered')->doesntExist()) {
                //Cek Keberadaan Data Filter
                throw new Exception("Pastikan Data Seleksi Mandiri Telah Melewati Tahap Filter", 1);
            } elseif (
                CandidateMand::query()->where('periode', intval($tahun))->where('status', 'done')->exists() &&
                Criteria::query()->where('tahun', intval($tahun))->where('table', 'finish_candidates_mand')->exists()
            ) {
                //Cek Keberadaan Data Finish
                $candidates = CandidateMand::query()->where('periode', intval($tahun))->where('status', 'done')->get();
                $criteria = Criteria::query()->select('kolom')->where('tahun', intval($tahun))->where('table', 'finish_candidates_mand')->first();
                $mand = [
                    'candidate' => $candidates,
                    'kolom' => $criteria->kolom,
                ];
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

    public function getData()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'id' => 'required',
                'nama' => 'required',
                'jurusan' => 'required',
                'alamat' => 'required',
                'tahap' => 'required',
            ]);
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $tahap = request('tahap');
            $kolom = [request('id'), request('nama'), request('jurusan'), request('alamat')];

            $response = FinishController::search($tahun, $pendidikan, $tahap, $kolom);

            return response()->json($response->original);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function search($tahun, $pendidikan, $tahap, $kolom)
    {
        try {
            switch ($tahap) {
                case 'pres':
                    $data = CandidatePres::query()
                        ->select($kolom[0], $kolom[1], $kolom[2], $kolom[3])
                        ->where('status', 'filtered')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                case 'tes':
                    $data = CandidateTes::query()
                        ->select($kolom[0], $kolom[1], $kolom[2], $kolom[3])
                        ->where('status', 'filtered')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                case 'mand':
                    $data = CandidateMand::query()
                        ->select($kolom[0], $kolom[1], $kolom[2], $kolom[3])
                        ->where('status', 'filtered')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                default:
                    throw new Exception("Pastikan Tahap Telah Benar", 1);
                    break;
            }

            return response()->json([
                "data" => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function save()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'id' => 'required',
                'nama' => 'required',
                'jurusan' => 'required',
                'alamat' => 'required',
                'tahap' => 'required',
            ]);
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $tahap = request('tahap');
            $kolom = [request('id'), request('nama'), request('jurusan'), request('alamat')];

            $response = FinishController::search($tahun, $pendidikan, $tahap, $kolom);
            $response = $response->original;
            $candidates = $response['data'];

            for ($i = 0; $i < count($candidates); $i++) {
                unset($candidates[$i]['_id']);
                $candidates[$i]['status'] = "done";
                $candidates[$i]['periode'] = intval($tahun);
            }

            switch ($tahap) {
                case 'pres':
                    $table = 'finish_candidates_pres';
                    CandidatePres::insert($candidates);
                    break;

                case 'tes':
                    $table = 'finish_candidates_tes';
                    CandidateTes::insert($candidates);
                    break;

                case 'mand':
                    $table = 'finish_candidates_mand';
                    CandidateMand::insert($candidates);
                    break;

                default:
                    throw new Exception("Pastikan Tahap Telah Benar", 1);
                    break;
            }


            $criteria = array(
                'tahun' => intval($tahun),
                'kolom' => $kolom,
                'table' => $table,
                'kode_criteria' => strval($tahun) . '_' . $table,
            );

            Criteria::query()->where('kode_criteria', strval($tahun) . '_' . $table)->delete();
            Criteria::insert($criteria);

            // dd($candidates, $criteria);

            return response()->json([
                'status' => 'Data Calon Mahasiswa Tahun ' . $tahun . ' Berhasil Dikunci',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function export()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'tahap' => 'required',
            ]);
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $tahap = request('tahap');

            $kolom = Criteria::query()
                ->select('kolom')
                ->where('tahun', intval($tahun))
                ->where('table', 'finish_candidates_' . $tahap)
                ->first();
            $kolom = $kolom->kolom;
            switch ($tahap) {
                case 'pres':
                    $data = CandidatePres::query()
                        ->select(strval($kolom[0]), strval($kolom[1]), strval($kolom[2]), strval($kolom[3]))
                        ->where('status', 'done')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                case 'tes':
                    $data = CandidateTes::query()
                        ->select(strval($kolom[0]), strval($kolom[1]), strval($kolom[2]), strval($kolom[3]))
                        ->where('status', 'done')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                case 'mand':
                    $data = CandidateMand::query()
                        ->select(strval($kolom[0]), strval($kolom[1]), strval($kolom[2]), strval($kolom[3]))
                        ->where('status', 'done')
                        ->where('periode', intval($tahun))
                        ->get()->toArray();
                    break;

                default:
                    throw new Exception("Pastikan Tahap Telah Benar", 1);
                    break;
            }
            if ($data == null) {
                throw new Exception("Pastikan telah mengunci data", 1);
            };

            for ($i = 0; $i < count($data); $i++) {
                unset($data[$i]['_id']);
            }

            array_unshift($data, $kolom);
            $export = new CandidatesExport($data);
            return Excel::download($export, 'export-data-mahasiswa-baru-tahap-' . strval($tahap) . '-tahun-' . strval($tahun) . '.xlsx', null, $kolom);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
