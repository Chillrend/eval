<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Tempory_Prestasi extends Model
{
    use HasFactory;

    protected $table = 'tempory_preview_prestasi';
    protected $connection = 'mongodb';
}
