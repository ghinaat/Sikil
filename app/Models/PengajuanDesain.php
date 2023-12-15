<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDesain extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengajuan_desain';
    protected $table = 'pengajuan_desain';
    protected $fillable = [
        'id_users',
        'tgl_pengajuan',
        'nama_kegiatan',
        'tempat_kegiatan',
        'tgl_kegiatan',
        'tgl_digunakan',
        'jenis_desain',
        'ukuran',
        'lampiran_pendukung',
        'lampiran_qrcode',
        'no_sertifikat',
        'keterangan_pemohon',
        'keterangan',
        'lampiran_desain',
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
