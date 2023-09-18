<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_surat';
    protected $table = 'surat';

    protected $fillable = [
        'id_users',
        'id_kode_surat',
        'no_surat',
        'jenis_surat',
        'urutan',
        'tgl_ajuan',
        'tgl_surat',
        'keterangan',
        'status',
        'bulan_kegiatan',
        'is_deleted'

    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
    public function kodesurat(){
        return $this->belongsTo(KodeSurat::class, 'id_kode_surat', 'id_kode_surat');
    }


}
