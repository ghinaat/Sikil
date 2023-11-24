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

}