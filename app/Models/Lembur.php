<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_lembur';

    protected $table = 'lembur';

    protected $fillable = [
        'kode_finger',
        'id_atasan',
        'tanggal',
        'jam_mulai',
        'kam_selesai',
        'jam_lembur',
        'tugas',
        'status_izin_atasan',
        'alasan_ditolak_atasan',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_finger', 'kode_finger');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'id_atasan', 'id_users');
    }
}