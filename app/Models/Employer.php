<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Employer
 *
 * @property mixed|null $id
 * @property ?User $user
 * @property ?EmployerAddress $address
 */
class Employer extends Model
{
    use HasFactory, SoftDeletes;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(EmployerAddress::class);
    }
}
