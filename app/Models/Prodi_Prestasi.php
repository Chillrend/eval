<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Prodi_Prestasi extends Model
{
    use HasFactory;
    
    protected $table = 'prodi_prestasi';
    protected $connection = 'mongodb';
}
