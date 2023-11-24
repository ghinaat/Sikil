<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Routing\Loader\ProtectedPhpFileLoader;

class PengajuanForm extends Model
{
    use HasFactory;
    
    protected $guarded = ['id_pengajuan_form'];
    protected $primaryKey = 'id_pengajuan_form';
    protected $date = ['tgl_pengajuan', 'tgl_digunakan'];
    protected $table = 'pengajuan_form';

    
}