<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Picklist
 *
 * @property string $name
 * @property string $slug
 * @property ?string $description
 */
class Picklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PicklistItem::class);
    }
}
