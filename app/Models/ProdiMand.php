<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProdiMand extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
}
