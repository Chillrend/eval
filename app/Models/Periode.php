<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode_candidates';
    protected $connection = 'mongodb';
}
