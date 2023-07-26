<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDiklat extends Model
{
    use HasFactory;
    protected $table = 'jenis_diklat';

    protected $primaryKey = 'id_jenis_diklat';
    protected $fillable = [
        'nama_jenis_diklat',
        'is_deleted'
    ];
}