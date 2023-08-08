<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory;

    protected $table = 'hubungan_keluarga';

    protected $primaryKey = 'id_hubungan';

    protected $fillable = [
        'urutan',
        'nama',
    ];
}
