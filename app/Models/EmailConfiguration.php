<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    use HasFactory;

    protected $guarded = 'id_email_configuration';

    protected $table = 'email_configuration';

    protected $primaryKey = 'id_email_configuration';

}