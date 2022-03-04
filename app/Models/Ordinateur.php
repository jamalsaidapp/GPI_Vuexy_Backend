<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Wildside\Userstamps\Userstamps;

class Ordinateur extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $fillable = [

        'marque','reference','sn','ram','disk','processor','affecter','state','remarque',
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
    ];

    public function salaries()
    {
        return $this->belongsToMany(Salarie::class);
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
