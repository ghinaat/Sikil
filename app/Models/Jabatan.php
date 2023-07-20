<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    
    protected $table = 'tb_jabatan';
    protected $keyType = 'int';
    protected $primaryKey = 'id_jabatan';
    protected $fillable = [
        'nama_jabatan',
        'is_deleted'
       
    ];
}