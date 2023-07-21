<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimKegiatan extends Model
{
    use HasFactory;
    protected $table = 'tb_tim_kegiatan';
 
    protected $primaryKey = 'id_tim';
    protected $fillable = [
        'id_kegiatan',
        'id_pegawai',
  
    ];

    public function fkegiatan(){
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan'
    );
        }

    public function fpegawai(){
            return $this->belongsTo(User::class, 'id_pegawai', 'id_users'
        );
            }
}