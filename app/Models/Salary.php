<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Wildside\Userstamps\Userstamps;
use App\Traits\SecureDelete;

class Salary extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SecureDelete;

    protected $fillable = [
        'full_name', 'user_id', 'is_user', 'phone_id', 'cin'
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'deleted_at' => 'datetime:m/d/Y',
        'updated_at' => 'datetime:m/d/Y',
    ];


    public function affected_laptops()
    {
        return $this->belongsToMany(Laptop::class, 'laptop_salary')->withTimestamps()
            ->withPivot(['projet_id', 'affected_at', 'remarque', 'created_by', 'updated_by'])->using(Affectation::class);
    }
    public function returned_laptops()
    {
        return $this->belongsToMany(Laptop::class, 'return_salary')->withTimestamps()
            ->withPivot(['affected_at', 'projet_id', 'rendu_at', 'raison', 'remarque', 'created_by', 'updated_by'])->using(Retour::class);
    }

    public function affected_projets()
    {
        return $this->belongsToMany(Projet::class, 'laptop_salary');
    }

    public function returned_projets()
    {
        return $this->belongsToMany(Projet::class, 'return_salary');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }


    public function setCreatedByAttribute()
    {
        $this->attributes['created_by'] = Auth::user()->getUserFullName();
    }

    public function setUpdatedByAttribute()
    {
        $this->attributes['updated_by'] = Auth::user()->getUserFullName();
    }
    public function setDeletedByAttribute()
    {
        $this->attributes['deleted_by'] = Auth::user()->getUserFullName();
    }
}
