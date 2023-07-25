<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    protected $table = 'keluarga';
    protected $primaryKey = 'id_keluarga';
    protected $fillable = [
        'id_users',
        'id_hubungan',
        'nama',
        'tanggal_lahir',
        'gender',
        'status'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function hubkel(){
        return $this->belongsTo(HubunganKeluarga::class, 'id_hubungan', 'id_hubungan');
    }
}
