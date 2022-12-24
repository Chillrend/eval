<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use App\Models\ProdiMand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FilterMandiriController extends Controller
{
    public function render()
    {
        // dd(request()->all());

        $search = request('search');
        $collumn = request('kolom');

        $ncollumn = request('banyakCollumn');

        $filter = [];
        for ($i = 0; $i < request('banyakCollumn'); $i++) {
            $filter[$i][0] = strtolower(request('kolom-' . strval($i)));
            $filter[$i][1] = strtolower(request('operator-' . strval($i)));
            $filter[$i][2] = strtolower(request('nilai-' . strval($i)));
        }

        // dd([$search, $collumn, $ncollumn]);
        $candidates = CandidateMand::query()->where('status', 'post-import')
            ->when($ncollumn, function ($query) use ($filter) {
                return $query->where(function ($query) use ($filter) {
                    for ($a = 0; $a < count($filter); $a++) {
                        $query->where($filter[$a][0], $filter[$a][1], intval($filter[$a][2]));
                    }
                });
            })
            ->when($search && $collumn, function ($query) use ($collumn, $search) {
                return $query->where(function ($query) use ($collumn, $search) {
                    if (is_numeric($search)) {
                        $query->where($collumn, intval($search));
                    } else {
                        $query->where($collumn, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate(10);

        $criteria = Criteria::query()->where('table', 'candidates_mand')->get();

        return view('halaman.filter-mandiri', [
            'type_menu' => 'mandiri',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
            'filter' => $filter,
        ]);
    }

    public function api_render(Request $request)
    {
        try {
            $response = FilterMandiriController::filtering($request);
            return response()->json($response->original);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function filtering($request)
    {
        $this->validate(request(), [
            'jurusan_kolom' => 'required',
        ]);

        if (CandidateMand::query()->where('status', 'post-import')->exists()) {

            $filter = request('filter') ? request('filter') : null;
            if (request('tahun')) {
                $tahun = request('tahun');
            } else {
                $tahun = CandidateMand::select('periode')
                    ->where('status', 'post-import')
                    ->first()->toArray();
                $tahun = $tahun['periode'];
            }

            $criteria = Criteria::select('bobot', 'kolom', 'binding')->where('table', 'candidates_mand')->where('tahun', intval($tahun))->first();
            $bind = $criteria->binding;

            $prodi = ProdiMand::all()->toArray();

            //binding - kuota
            for ($index = 0; $index < count($bind); $index++) {
                $i = array_search($bind[$index]['id_obj'], array_column($prodi, 'id'));
                $bind[$index]['kuota'] = $prodi[$i]['kuota'];
                $bind[$index]['nama'] = $prodi[$i]['prodi'];
            }

            // pisahin bobot
            $bobot = (array) $criteria->bobot;
            $bobobot = [
                'prioritas' => [],
                'pembobotan' => [],
                'tambahan' => [],
            ];
            foreach ($bobot as $bobott) {
                switch ($bobott['tipe']) {
                    case 'prioritas':
                        array_push($bobobot['prioritas'], $bobott);
                        break;
                    case 'pembobotan':
                        array_push($bobobot['pembobotan'], $bobott);
                        break;
                    case 'tambahan':
                        array_push($bobobot['tambahan'], $bobott);
                        break;
                    default:
                        return response()->json([
                            'eror' => 'Terjadi Error'
                        ]);
                        break;
                }
            }

            //ambil non prioritas
            $nonprio = CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))
                ->where(function ($query) use ($bobobot) {
                    foreach ($bobobot['prioritas'] as $bobott) {
                        $query->where($bobott['kolom'], '!=', $bobott['nilai']);
                    }
                })
                ->when($filter, function ($query) use ($filter) {
                    return $query->orWhere(function ($query) use ($filter) {
                        for ($a = 0; $a < count($filter); $a++) {
                            $query->where($filter[$a][0], $filter[$a][1], intval($filter[$a][2]));
                        }
                    });
                })
                ->get()->toArray();

            //total
            for ($i = 0; $i < count($nonprio); $i++) {
                $total = 0;
                if ($bobobot['pembobotan']) {
                    $val = 0;
                    foreach ($bobobot['pembobotan'] as $bobotan) {
                        if ($nonprio[$i][$bobotan['kolom']] == $bobotan['nilai']) {
                            $val = intval($bobotan['bobot']);
                        }
                    }
                    $total += $val;
                }
                if ($bobobot['tambahan']) {
                    $val = 0;
                    foreach ($bobobot['tambahan'] as $bobotan) {
                        $val += intval($nonprio[$i][$bobotan['kolom']]);
                    }
                    $total += $val;
                }
                $nonprio[$i]['total'] = $total;
            }

            //sorting
            $nonprio = collect($nonprio);

            $nonprio = $nonprio->sortBy([
                ['total', 'desc'],
            ]);

            $candidates = $nonprio->all();

            //ambil prioritas
            if (isset($bobobot['prioritas'])) {
                $prioritas = CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))
                    ->orWhere(function ($query) use ($bobobot) {
                        foreach ($bobobot['prioritas'] as $bobott) {
                            $query->orWhere($bobott['kolom'], $bobott['nilai']);
                        }
                    })->get()->toArray();
                if ($prioritas != null) {
                    $candidates  = array_merge($prioritas, $candidates);
                }
            }

            //kuota
            try {
                $final = [];
                foreach ($bind as $binds) {
                    for ($i = 0; $i < $binds['kuota']; $i++) {
                        $a = array_search($binds['bind_prodi'], array_column($candidates, request('jurusan_kolom')));
                        if (is_numeric($a)) {
                            array_push($final, $candidates[$a]);
                            unset($candidates[$a]);
                            $candidates = array_values($candidates);
                        }
                    }
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'Silahkan pilih kolom yang lain untuk jurusan'
                ]);
            }

            $kolom_filter = [];
            foreach ($bobobot['tambahan'] as $bobott) {
                array_push($kolom_filter, $bobott['kolom']);
            }

            $list_tahun = CandidateMand::select('periode')
                ->where('status', 'post-import')
                ->groupBy('periode')
                ->orderBy('periode', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($list_tahun); $x++) {
                $list_tahun[$x] = $list_tahun[$x]['periode'];
            }

            $tahun_template = Criteria::select('tahun')
                ->where('table', 'filter_candidates_mand')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($tahun_template); $x++) {
                $tahun_template[$x] = $tahun_template[$x]['tahun'];
            }

            $kolom = $criteria->kolom;
            return response()->json([
                'candidates' => $final,
                'kolom' => $kolom,
                'kolom_filter' => $kolom_filter,
                'list_tahun' => $list_tahun,
                'tahun_template' => $tahun_template,
                'filter' => $filter,
                'status' => [
                    'tahun' => $tahun,
                ],
            ]);
        } else {
            return response()->json([
                'eror' => 'Silahkan untuk menyimpan hasil import calon mahasiswa'
            ]);
        }
    }

    public function save(Request $request)
    {
        try {
            $filter = [];
            $operator = [];
            for ($i = 0; $i < request('banyakCollumn'); $i++) {
                $filter[$i]['kolom'] = strtolower(request('kolom-' . strval($i)));

                match (request('operator-' . strval($i))) {
                    '=' => $filter[$i]['operator'] = 'et',
                    '>' => $filter[$i]['operator'] = 'gt',
                    '<' => $filter[$i]['operator'] = 'lt',
                    '>=' => $filter[$i]['operator'] = 'gtet',
                    '<=' => $filter[$i]['operator'] = 'ltet',
                    '<>' => $filter[$i]['operator'] = 'net',
                };

                $filter[$i]['nilai'] = strtolower(request('nilai-' . strval($i)));
                $operator[$i] = strtolower(request('operator-' . strval($i)));
            }

            $criteria = Criteria::query()->where('kode_criteria', request('periode') . '_candidates_mand')->first();
            $array = array(
                'tahun' => now()->year,
                'kolom' => $filter,
                'table' => 'filter_candidates_mand',
                'kode_criteria' => strval(now()->year) . '_filter_candidates_mand',
            );
            $criteria->filter = $array;
            $criteria->save();

            $candidates = CandidateMand::query()->where('status', 'post-import')
                ->when(request('banyakCollumn'), function ($query) use ($filter, $operator) {
                    return $query->where(function ($query) use ($filter, $operator) {
                        for ($a = 0; $a < count($operator); $a++) {
                            $query->where($filter[$a]['kolom'], $operator[$a], intval($filter[$a]['nilai']));
                        }
                    });
                })
                ->update(['status' => 'filtered']);

            CandidateMand::query()->where('status', 'post-import')->delete();

            return response()->json([
                'status' => 'done',
                'route' => url('/preview-mandiri'),
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => '' . $th,
            ]);
        }
    }

    public function api_save(Request $request)
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $tahun = request('tahun');

            $filteri = request('filter') ? request('filter') : null;
            $operator = [];
            $filter = [];

            if ($filteri != null) {
                for ($i = 0; $i < count($filteri); $i++) {
                    $filter[$i]['kolom'] = $filteri[$i][0];
                    $filter[$i]['nilai'] = $filteri[$i][2];
                    match ($filteri[$i][1]) {
                        '=' => $filter[$i]['operator'] = 'et',
                        '>' => $filter[$i]['operator'] = 'gt',
                        '<' => $filter[$i]['operator'] = 'lt',
                        '>=' => $filter[$i]['operator'] = 'gtet',
                        '<=' => $filter[$i]['operator'] = 'ltet',
                        '<>' => $filter[$i]['operator'] = 'net',
                    };
                    $operator[$i] = strtolower($filteri[$i][1]);
                }
            } else {
                $filter = null;
            }

            $criteria = array(
                'tahun' => intval($tahun),
                'kolom' => $filter,
                'table' => 'filter_candidates_mand',
                'kode_criteria' => strval($tahun) . '_filter_candidates_mand',
            );

            $response = FilterMandiriController::filtering($request);
            $response = $response->original;
            $candidates = $response['candidates'];

            for ($i = 0; $i < count($candidates); $i++) {
                $candidates[$i]['status'] = "filtered";
            }

            $tahun = $response['status']['tahun'];
            CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))->delete();
            CandidateMand::insert($candidates);

            if (Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_mand')->exists()) {
                Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_mand')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            return response()->json([
                'status' => 'Filter Calon Mahasiswa ' . $tahun . ' Berhasil',
                'redirect' => route('api_renderPreviewMand')
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getFilter()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $criteria = Criteria::select('kolom')->where('table', 'filter_candidates_mand')->where('tahun', intval(request('tahun')))->first();
            $kolom = [];
            foreach ($criteria->kolom as $ckolom) {
                match ($ckolom['operator']) {
                    'et' => $ckolom['operator'] = '=',
                    'gt' => $ckolom['operator'] = '>',
                    'lt' => $ckolom['operator'] = '<',
                    'gtet' => $ckolom['operator'] = '>=',
                    'ltet' => $ckolom['operator'] = '<=',
                    'net' => $ckolom['operator'] = '<>',
                };
                array_push($kolom, $ckolom);
            }
            return response()->json([
                'kolom' => $kolom,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
