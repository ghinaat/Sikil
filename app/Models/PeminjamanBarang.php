<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBarang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barang';

    protected $primaryKey = 'id_peminjaman';

    protected $date = ['tgl_ajuan', 'tgl_peminjaman', 'tgl_pengembalian']
    ;

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }


    protected $guarded = ['id_peminjaman'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl_ajuan = now();
        });

    }
}