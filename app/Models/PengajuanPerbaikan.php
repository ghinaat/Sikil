<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPerbaikan extends Model
{
    use HasFactory;

    protected $guarded = ['id_pengajuan_perbaikan'];
    protected $primaryKey = 'id_pengajuan_perbaikan';
    protected $date = ['tgl_pengajuan', 'tgl_pengecekan', 'tgl_selesai'];
    protected $table = 'pengajuan_perbaikan';

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function barang()
    {
        return $this->belongsTo(BarangTik::class, 'id_barang_tik', 'id_barang_tik');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl_pengajuan = now();
        });

    }
}