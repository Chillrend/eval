<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;
    protected $table = 'candidates_prestasi';
    protected $connection = 'mongodb';
}
