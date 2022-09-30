<?php

namespace App\Imports;

use App\Models\Candidates;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class CandidatesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;
    public function model(array $row) : Candidates
    {
        return new Candidates([
            
            
        ]);

        
    }
}
