<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class CandidatePres extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'candidate_pres';

}
