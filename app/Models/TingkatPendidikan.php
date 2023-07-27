<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'tingkat_pendidikan';
 
    protected $primaryKey = 'id_tingkat_pendidikan';
    protected $fillable = [
        'nama_tingkat_pendidikan',
        'is_deleted'
    ];
}
