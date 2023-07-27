<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diklat extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_diklat';
    protected $table = 'diklat';
    protected $fillable = [
        'id_users',
        'id_jenis_diklat',
        'nama_diklat',
        'penyelenggara',
        'tanggal_diklat',
        'jp',
        'file_sertifikat',
        'is_deleted'
    ];
    public function jenisdiklat(){
        return $this->belongsTo(JenisDiklat::class, 'id_jenis_diklat', 'id_jenis_diklat');
        }

    public function users(){
        return $this->belongsTo(User::class, 'id_users', 'id_users');
        }
}