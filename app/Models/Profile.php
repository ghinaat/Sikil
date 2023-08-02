<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile_user';

    protected $primaryKey = 'id_profile_user';

    protected $date = 'tanggal_lahir';

    public function tingkat_pendidikan(){
        return $this->belongsTo(TingkatPendidikan::class, 'id_tingkat_pendidikan', 'id_tingkat_pendidikan');
    } 

    protected $guarded = ['id_profile_user'];
}