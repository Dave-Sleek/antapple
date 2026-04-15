<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_subscribed',
        'is_active',
        'company_name',
        'company_logo',
        'phone',
        'website',
        'location',
        'about_company',
        'linkedin',
        'twitter',
        'profile_completed',
    ];

    public function profileCompletion()
    {
        $fields = [
            'name',
            'email',
            'company_name',
            'company_logo',
            'about_company',
            'location',
            'phone',
            'website'
        ];

        $filled = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) $filled++;
        }

        return round(($filled / count($fields)) * 100); // returns 0-100%
    }

    public function getLogoUrlAttribute()
    {
        return $this->company_logo
            ? asset('storage/' . $this->company_logo)
            : asset('images/default-company.png');
    }


    public function jobPostingLimit()
        {
            if (!$this->subscription) {
            return 3; // free
        }

        return match ($this->subscription->plan->name) {
            'basic' => 10,
            'pro' => 30,
            default => 3,
        };
            }

        public function jobsPostedCount()
            {
                $startDate = optional($this->subscription)->started_at;

                if (!$startDate) {
                    return $this->jobs()->count();
                }

                return $this->jobs()
                    ->where('created_at', '>=', $startDate)
                    ->count();
            }

       public function hasReachedJobLimit()
        {
            return $this->jobsPostedCount() >= $this->jobPostingLimit();
        }


    public function getIsVerifiedAttribute()
    {
        // A company is verified if it has at least 3 active jobs and profile is at least 80% complete
        return $this->jobs()->where('status', 'active')
            ->where('is_verified', true)
            ->exists();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'profile_completed' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscription &&
            $this->subscription->isActive();
    }

    public function jobs()
    {
        return $this->hasMany(Job_post::class, 'user_id');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function canPostJob()
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $jobCount = $this->jobs()->count();
        return $jobCount < $this->subscription->plan->job_limit;
    }

    public function opportunities()
        {
            return $this->hasMany(\App\Models\Opportunity::class);
        }


    public function dashboardRoute()
    {
        return match ($this->role) {
            'admin' => route('admin.dashboard'),
            'employer' => route('employer.dashboard'),
            default => route('profile.notifications'),
        };
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
