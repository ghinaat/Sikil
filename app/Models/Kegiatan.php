<?php

namespace App\Models;

use Carbon\Carbon;

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

    protected $appends = ['status'];


    public function getStatusAttribute()
    {
        $today = Carbon::now();
        $start = Carbon::parse($this->attributes['tgl_mulai']);
        $end = Carbon::parse($this->attributes['tgl_selesai']);

        if ($today->lt($start)) {
            return 'Belum Dimulai';
        } elseif ($today->gt($end)) {
            return 'Selesai';
        } else {
            return 'Sedang Berlangsung';
        }
    }

    

    public function timKegiatan()
    {
        return $this->hasMany(TimKegiatan::class);
    }
}