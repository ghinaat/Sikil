<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanZoom extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_zoom';

    protected $primaryKey = 'id_pengajuan_zoom';

    protected $fillable = [    
        'id_users',
        'tgl_pengajuan',
        'jenis_zoom',
        'nama_kegiatan',
        'jumlah_peserta',
        'tgl_pelaksanaan',
        'jam_mulai',
        'jam_selesai',
        'keterangan_pemohon',
        'keterangan_operator',
        'nama_operator',
        'akun_zoom',
        'status',      
        'is_deleted',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

  

    protected $guarded = ['id_pengajuan_zoom'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl_pengajuan = now();
        });

    }
}
