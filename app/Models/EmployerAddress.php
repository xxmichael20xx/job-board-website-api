<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * EmployerAddress
 *
 * @property int $employer_id
 * @property string $street_1
 * @property string $string_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property Employer $employer
 */
class EmployerAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employer_id',
        'street_1',
        'string_2',
        'city',
        'state',
        'zip',
        'country'
    ];

    /**
     * Get the employer associated with the employer address.
     *
     * @return BelongsTo
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
