<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_setting';

    protected $primaryKey = 'id_general';

    protected $fillable = [
        'tahun_aktif',
        'id_users',
        'status',
    ];

    public function id_ppk()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
