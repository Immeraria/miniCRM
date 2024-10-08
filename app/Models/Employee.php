<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'company_id',
        'email',
        'phone_num',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}
