<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $primarykey = 'id_presensi';

    protected $table = 'presensi';

    protected $fillable = [
        'kode_finger',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'terlambat',
        'pulang_cepat',
        'kehadiran',
        'jenis_perizinan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_finger', 'kode_finger');
    }

    
}
