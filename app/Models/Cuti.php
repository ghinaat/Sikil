<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cuti';

    protected $table = 'cuti';

    protected $fillable = ['id_users', 'jatah_cuti', 'is_deleted'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}


