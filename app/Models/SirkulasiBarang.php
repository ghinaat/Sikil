<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SirkulasiBarang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_sirkulasi_barang';
    protected $table = 'sirkulasi_barang';
    protected $fillable = [
        'id_barang_ppr',
        'id_users',
        'tgl_sirkulasi',
        'jumlah',
        'jenis_sirkulasi',
        'keterangan',
        'is_deleted',
    ];

    public function barangppr()
    {
        return $this->belongsTo(BarangPpr::class, 'id_barang_ppr', 'id_barang_ppr');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $model->tgl_sirkulasi = now();
        });  
    }
}
