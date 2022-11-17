<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProdiMand extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'prodi_mand';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_prodi', 'prodi', 'kelompok_bidang', 'kuota'
    ];    
}
