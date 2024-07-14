<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Job
 *
 * @property int $id
 * @property int $employer_id
 * @property string $title
 * @property string $description
 * @property int|float $expected_salary
 * @property int $vacancy
 * @property bool $requires_resume
 * @property bool $status
 * @property string|Carbon $expire_at
 * @property Employer $employer
 */
class Job extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Static salary range
     *
     * @return array|int[]
     */
    public static function salaryRange(): array
    {
        return [
            10000, 15000, 20000, 25000, 30000, 35000, 40000, 50000, 55000, 75000, 90000
        ];
    }

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'expected_salary',
        'vacancy',
        'requires_resume',
        'status',
        'expire_at',
    ];

    protected $casts = [
        'requires_resume' => 'boolean',
        'status' => 'integer',
        'expire_at' => 'datetime',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(PicklistItem::class, 'job_has_skills', 'job_id', 'picklist_item_id');
    }
}
