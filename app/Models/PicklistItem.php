<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * PicklistItem
 *
 * @property int $picklist_id
 * @property string $name
 * @property string $slug
 * @property ?string $description
 * @property Picklist $picklist
 */
class PicklistItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'picklist_id',
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the picklist associated with the picklist item.
     *
     * @return BelongsTo
     */
    public function picklist(): BelongsTo
    {
        return $this->belongsTo(Picklist::class);
    }

    /**
     * Get the jobs associated with the picklist item.
     *
     * @return BelongsToMany
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_has_skills', 'picklist_item_id', 'job_id');
    }
}
