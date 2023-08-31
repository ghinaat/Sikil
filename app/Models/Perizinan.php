<?php

namespace App\Models;
use App\Grei\TanggalMerah;
use DateTime;
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


    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $model->tgl_ajuan = now();
        });

        static::saving(function ($perizinan) {
            $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
                $perizinan->tgl_absen_awal,
                $perizinan->tgl_absen_akhir
            );

            $perizinan->attributes['jumlah_hari_pengajuan'] = $jumlah_hari_pengajuan;
        });
    }

      public function is_saturday()
        {
            $day = $this->date->format("D");
            if ($day === "Sat") {
                $this->event[] = 'saturday';
                return true;
            } else {
                return false;
            }
        }


    public function hitungJumlahHariPengajuan($tgl_absen_awal, $tgl_absen_akhir)
    {
        $tanggalMerah = new TanggalMerah();
        $tgl_awal = new DateTime($tgl_absen_awal);
        $tgl_akhir = new DateTime($tgl_absen_akhir);
        $jumlah_hari_pengajuan = 0;
        while ($tgl_awal <= $tgl_akhir) {
            $tanggalMerah->set_date($tgl_awal->format('Y-m-d'));

            if (!$tanggalMerah->is_holiday() && !$tanggalMerah->is_sunday() && !$tanggalMerah->is_saturday()) {
                $jumlah_hari_pengajuan++;
            }

            $tgl_awal->modify('+1 day');
        }

        return $jumlah_hari_pengajuan;
    }

}