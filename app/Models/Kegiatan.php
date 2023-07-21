<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'tb_kegiatan';
 
    protected $primaryKey = 'id_kegiatan';
    protected $fillable = [
        'nama_kegiatan',
        'tgl_mulai',
        'tgl_selesai',
        'lokasi',
        'peserta',
        'is_deleted'
       
    ];

    public function timKegiatan()
    {
        return $this->hasMany(TimKegiatan::class);
    }
}