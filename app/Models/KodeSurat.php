<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeSurat extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kode_surat';

    protected $table = 'kode_surat';

    protected $fillable = [
        'divisi',
        'kode_surat',
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_surat', 'id_surat');
    }
}
