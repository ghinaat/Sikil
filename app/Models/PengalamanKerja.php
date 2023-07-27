<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengalaman_kerja';
    protected $table = 'pengalaman_kerja';
    protected $fillable = [
        'nama_perusahaan',
        'masa_kerja',
        'file_kerja',
        'posisi',
        'id_users',
        'is_deleted'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}