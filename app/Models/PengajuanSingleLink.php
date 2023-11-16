<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSingleLink extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengajuan_singlelink';
    protected $table = 'pengajuan_singlelink';
    protected $fillable = [
        'id_users',
        'tgl_pengajuan',
        'nama_kegiatan',
        'nama_shortlink',
        'keterangan_pemohon',
        'keterangan_operator',
        'status',
        'is_deleted',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $model->tgl_pengajuan = now();
        });  
    }
}
