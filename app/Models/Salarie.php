<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Wildside\Userstamps\Userstamps;

class Salarie extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'full_name',
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'deleted_at' => 'datetime:m/d/Y',
        'updated_at' => 'datetime:m/d/Y',
    ];

    public function ordinateurs()
    {
        return $this->belongsToMany(Ordinateur::class)->using(Affectation::class)
            ->withTimestamps()->withPivot(['affected_at','remarque','created_by','updated_by']);
    }
    public function ordinateurs_rendus()
    {
        return $this->belongsToMany(Ordinateur::class,'retour_salarie')->using(Rendu::class)
            ->withTimestamps()->withPivot(['affected_at','rendu_at','remarque','created_by','updated_by']);
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
