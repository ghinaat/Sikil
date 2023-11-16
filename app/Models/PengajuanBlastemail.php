<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBlastemail extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengajuan_blastemail';
    protected $guarded = ['id_pengajuan_blastemail'];

    protected $table = 'pengajuan_blastemail';
    protected $fillable =[
        'id_users',
        'tgl_pengajuan',
        'jenis_blast',
        'nama_kegiatan',
        'keterangan_pemohon',
        'lampiran',
        'keterangan_operator',
        'status',
        'is_deleted'
    ];

    protected $date = ['tgl_pengajuan', 'tgl_kirim'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl_pengajuan = now();
            // dd($model->tgl_pengajuan);
        });

    }
}