<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Employer
 *
 * @property mixed|null $id
 * @property int $userId
 * @property string $company
 * @property string $email
 * @property string $logo
 * @property string $description
 * @property ?User $user
 * @property ?EmployerAddress $address
 */
class Employer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company',
        'email',
        'logo',
        'description'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->logo) {
                $model->logo = setUIAvatarUrl($model->company, true);
            }
        });
    }

    /**
     * Get the user associated with the employer.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the one address associated with the employer.
     *
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(EmployerAddress::class);
    }

    /**
     * Get the jobs associated with the employer.
     *
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id');
    }
}
