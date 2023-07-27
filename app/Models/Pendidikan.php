<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pendidikan';
    protected $table = 'pendidikan';
    protected $fillable = [
        'nama_sekolah',
        'jurusan',
        'tahun_lulus',
        'ijazah',
        'id_tingkat_pendidikan',
        'is_deleted',
        'id_users',
    
    ];

    public function users(){
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function tingpen(){
        return $this->belongsTo(TingkatPendidikan::class,  'id_tingkat_pendidikan',  'id_tingkat_pendidikan');
    }
}