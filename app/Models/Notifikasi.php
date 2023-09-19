<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $guarded = 'id_notifikasi';

    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notifikasi';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
