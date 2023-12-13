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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');

    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tgl_pengajuan = now();
            // dd($model->tgl_pengajuan);
        });

    }
}