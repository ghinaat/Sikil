<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $primarykey = 'id_perizinan';

    protected $table = 'perizinan';
    protected $fillable = [
        'id_atasan',
        'kode_finger',
        'jenis_perizinan',
        'tgl_ajuan',
        'tgl_absen_awal',
        'tgl_absen_akhir',
        'keterangan',
        'file_perizinan',
        'status_izin_atasan',
        'status_izin_ppk',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'kode_finger', 'kode_finger');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'id_atasan', 'id_users');
    }


    protected static function boot()
    {
    parent::boot();

    static::creating(function ($model) {
        $model->tgl_ajuan = now(); // Isi dengan tanggal yang sesuai
    });
    }

}