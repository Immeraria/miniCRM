<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'company_id',
        'email',
        'phone_num',
    ];
}
