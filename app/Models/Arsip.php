<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';

    protected $primaryKey = 'id_arsip';

    protected $fillable = [
        'id_users',
        'jenis',
        'keterangan',
        'file',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
