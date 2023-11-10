<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjamanBarang extends Model
{
    use HasFactory;
    protected $table = 'detail_peminjaman_barang';

    protected $primaryKey = 'id_detail_peminjaman';

    protected $date = 'tgl_kembali';

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanBarang::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function barang()
    {
        return $this->belongsTo(BarangTik::class, 'id_barang_tik', 'id_barang_tik');
    }


    protected $guarded = ['id_detail_peminjaman'];



}