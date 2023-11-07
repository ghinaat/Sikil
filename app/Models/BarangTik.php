<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangTik extends Model
{
    use HasFactory;
    protected $table = 'barang_tik';
    protected $primaryKey = 'id_barang_tik';
    protected $fillable = [
      'id_ruangan',
      'jenis_aset',
      'kode_barang',
      'nama_barang',
      'merek',
      'kelengkapan',
      'tahun_pembelian',
      'kondisi',
      'status_pinjam',
      'keterangan',
      'image',
      'is_deleted',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}