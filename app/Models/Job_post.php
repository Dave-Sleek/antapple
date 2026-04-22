<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job_post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'company_name',
        'is_verified',
        'about_company',
        'company_logo',
        'category_id',
        'job_type',
        'location',
        'experience_level',
        'salary_range',
        'short_description',
        'apply_url',
        'deadline',
        'is_featured',
        'featured_until',
        'status',
        'source',
        'is_remote', // NEW: boolean for remote jobs
        'is_paid',
        'is_approved',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
        'deadline'    => 'datetime',
        'is_remote'   => 'boolean', // NEW
        'is_verified' => 'boolean',
        'is_paid'    => 'boolean',
        'is_approved' => 'boolean',
        'deleted_at' => 'datetime',
        'dates' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(JobClick::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('is_paid', true)
            ->where('is_approved', true);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function jobViews()
    {
        return $this->hasMany(JobView::class);
    }

    public function isExpired(): bool
    {
        return $this->deadline && $this->deadline->isPast();
    }

    protected static function booted()
    {
        // Handle both creating and updating
        static::saving(function ($job) {
            // Set UUID only for new jobs
            if (!$job->exists && empty($job->uuid)) {
                $job->uuid = (string) Str::uuid();
            }

            // Generate/update slug if needed
            if ($job->isDirty('title') || !$job->slug) {
                $job->slug = static::generateUniqueSlug(
                    $job->title,
                    $job->exists ? $job->id : null
                );
            }
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $count = 1;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }

    protected static function slugExists($slug, $ignoreId = null)
    {
        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
