<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\CandidatePres;
use App\Models\CandidateTes;
use App\Models\Criteria;
use Exception;
use Hamcrest\Type\IsInteger;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BobotController extends Controller
{
    public function render()
    {
        return view('halaman.pembobotan', [
            'type_menu' => 'bobot',
        ]);
    }

    public function getTahun()
    {
        try {
            $year = Criteria::select('tahun')->groupBy('tahun')->orderBy('tahun', 'desc')->get()->toArray();
            for ($x = 0; $x < count($year); $x++) {
                $year[$x] = $year[$x]['tahun'];
            }
            return response()->json([
                'tahun' => $year,
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

    public function getTahap()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
            ]);
            $tahun = request('tahun');
            $pend = request('pendidikan');
            $tahap = Criteria::select('table')
                ->where('tahun', intval($tahun))
                ->where('table', 'like', 'candidate%')
                ->groupBy('table')
                ->get();
            for ($x = 0; $x < count($tahap); $x++) {
                $tahap[$x] = $tahap[$x]['table'];
            }
            return response()->json([
                'tahap' => $tahap,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function render_api()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'tahap' => 'required',
            ]);

            $pend = (request('pendidikan')) ? request('pendidikan') : 'S1';
            $tahun = (request('tahun')) ? request('tahun') : strval(date("Y"));
            $tahap = (request('tahap')) ? request('tahap') : 'candidates_tes';

            $criterias = Criteria::select('bobot')->where('kode_criteria', $tahun . '_' . $tahap)->first()->toArray();
            $criterias = $criterias['bobot'];

            $order = array('prioritas', 'pembobotan', 'tambahan');

            usort($criterias, function ($a, $b) use ($order) {
                $pos_a = array_search($a['tipe'], $order);
                $pos_b = array_search($b['tipe'], $order);
                return $pos_a - $pos_b;
            });
            dd($criterias);

            return response()->json([
                'criteria'  => $criterias,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getNilai()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'tahap' => 'required',
                'kolom' => 'required',
            ]);

            $pend = (request('pendidikan')) ? request('pendidikan') : 'S1';
            $tahun = (request('tahun')) ? request('tahun') : strval(date("Y"));
            $tahap = (request('tahap')) ? request('tahap') : 'candidates_tes';
            $kolom = request('kolom');

            switch ($tahap) {
                case 'candidates_tes':
                    $candidate = CandidateTes::select(strval($kolom))
                        ->where('periode', intval($tahun))
                        ->groupBy(strval($kolom))
                        ->get();
                    break;

                case 'candidates_pres':
                    $candidate = CandidatePres::select(strval($kolom))
                        ->where('periode', intval($tahun))
                        ->groupBy(strval($kolom))
                        ->get();
                    break;

                case 'candidates_mand':
                    $candidate = CandidateMand::select(strval($kolom))
                        ->where('periode', intval($tahun))
                        ->groupBy(strval($kolom))
                        ->get();
                    break;
            }
            for ($x = 0; $x < count($candidate); $x++) {
                $candidate[$x] = $candidate[$x][strval($kolom)];
            }

            return response()->json([
                'nilai'  => $candidate,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function api_insert()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'tahap' => 'required',
                'pembobotan' => 'required',
                'data' => 'required'
            ]);

            $pend = (request('pendidikan')) ? request('pendidikan') : 'S1';
            $tahun = (request('tahun')) ? request('tahun') : strval(date("Y"));
            $tahap = (request('tahap')) ? request('tahap') : 'candidates_tes';
            $data = request('data');

            if (Criteria::query()->where('kode_criteria', $tahun . '_' . $tahap)->exists()) {
                $criteria = Criteria::query()->where('kode_criteria', $tahun . '_' . $tahap)->first();
                switch (request('pembobotan')) {
                    case 'prioritas':
                        $array = [
                            'kolom'     => $data[0],
                            'nilai'     => $data[1],
                            'tipe'      => 'prioritas',
                        ];
                        break;

                    case 'pembobotan':
                        $array = [
                            'kolom'     => $data[0],
                            'nilai'     => $data[1],
                            'bobot'     => $data[2],
                            'tipe'      => 'pembobotan',
                        ];
                        break;

                    case 'tambahan':
                        $array = [
                            'kolom'     => $data[0],
                            'tipe'      => 'tambahan',
                        ];
                        break;

                    default:
                        return response()->json([
                            'error' => "pembobotan: attribute must whether 'prioritas', 'bobot', 'tambahan'",
                        ]);
                        break;
                }
                $bobot = (array) $criteria->bobot;

                if (is_numeric(array_search($array, $bobot))) {
                    return response()->json(['error' => "Data Telah Ditambahkan",]);
                } else {
                    array_push($bobot, $array);
                    $criteria->bobot = $bobot;
                }

                $criteria->save();
                return response()->json([
                    'status' => "Data " . ucfirst(request('pembobotan')) . " Berhasil Ditambahkan",
                ]);
            } else {
                return response()->json([
                    'error' => "Data tidak ditemukan, Pastikan anda telah memasukkan data dengan benar",
                ]);
            }
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function api_delete()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
                'tahap' => 'required',
                'pembobotan' => 'required',
                'id' => 'required|numeric'
            ]);

            $pend = request('pendidikan');
            $tahun = request('tahun');
            $tahap = request('tahap');
            $pembobotan = request('pembobotan');
            $id = request('id');

            $criteria = Criteria::select('bobot')->where('kode_criteria', $tahun . '_' . $tahap)->first();
            $bobot = $criteria->bobot;

            unset($bobot[$id]);
            $bobot = array_values($bobot);
            $criteria->bobot = $bobot;
            $criteria->save();
            dd($criteria);
            return response()->json([
                'status' => "Data " . ucfirst(request('pembobotan')) . " Berhasil Ditambahkan",
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
