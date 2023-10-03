<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran';

    protected $primaryKey = 'id_peran';

    protected $fillable = [
        'nama_peran',
        'is_deleted',
    ];
}