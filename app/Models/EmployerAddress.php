<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'street_1',
        'string_2',
        'city',
        'state',
        'zip',
        'country'
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
