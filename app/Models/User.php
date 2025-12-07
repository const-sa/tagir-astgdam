<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password','type','active','phone','image','city_id'
    // ];

    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getRoleAttribute()
    {
        return $this->roles->first();
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function workType()
    {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }
    public function jobrelation()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function scopeClients($q)
    {
        return $q->where('type', 'client');
    }

    public function scopeVendors($q)
    {
        return $q->where('type', 'vendor');
    }
    public function scopeDrivers($q)
    {
        return $q->where('type', 'driver');
    }

    public function scopeAdmins($q)
    {
        return $q->where('type', 'admin');
    }

    public function scopeEmployes($q)
    {
        return $q->where('type', 'employe');
    }
    public function scopeWorkers($q)
    {
        return $q->where('type', 'worker');
    }
    public function scopeAdministration($q)
    {
        return $q->where('type', 'administration-employe');
    }
    public function currentHiringProject()
    {
        return $this->belongsTo(HiringProject::class, 'hiring_project_id');
    }

    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }

    public function scopeInActive($q)
    {
        return $q->where('active', 0);
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'users_projects');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }
    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function jobs()
    {
      return $this->hasManyThrough(PriceQuotationJob::class,PriceQuotation::class ,'id','price_quotation_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(UserContract::class,'user_id');
    }
    // HiringProjects relation
    public function hiringProjects()
    {
        return $this->hasMany(HiringProject::class, 'client_id')->orderBy('created_at', 'desc');
    }

}
