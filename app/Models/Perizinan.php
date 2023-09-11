<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_perizinan';

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
        'alasan_ditolak_atasan',
        'status_izin_ppk',
        'alasan_ditolak_ppk',
        'is_deleted',
        'jumlah_hari_pengajuan'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'kode_finger', 'kode_finger');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'id_atasan', 'id_users');
    }
    // public function hitungJumlahHariPengajuan($tgl_awal, $tgl_akhir)
    // {
     
    //     $tanggal_awal = \Carbon\Carbon::parse($tgl_awal);
    //     $tanggal_akhir = \Carbon\Carbon::parse($tgl_akhir);
    //     $jumlah_hari = $tanggal_awal->diffInDays($tanggal_akhir);

    //     return $jumlah_hari;
    // }


    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $model->tgl_ajuan = now();
        });

          }

  
}