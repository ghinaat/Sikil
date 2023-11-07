<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPpr extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_barang_ppr';
    protected $table = 'barang_ppr';
    protected $fillable = [
        'id_ruangan',
        'nama_barang',
        'tahun_pembuatan',
        'jumlah',
        'keterangan',
        'image',
        'is_deleted',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
    public function sirkulasibarang()
    {
        return $this->hasMany(SirkulasiBarang::class, 'id_barang_ppr');
    }

}
