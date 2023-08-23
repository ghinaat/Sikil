<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $primaryKey = 'id_setting';

    protected $fillable = [
        'tahun_aktif',
        'id_users',
        'status',
    ];



    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}