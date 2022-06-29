<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\Auth;


class Projet extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = ['name', 'code'];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'affected_at' => 'datetime:Y-m-d',
        'rendu_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:m/d/Y',

    ];

    public function setCreatedByAttribute()
    {
        $this->attributes['created_by'] = Auth::user()->getUserFullName();
    }

    public function setUpdatedByAttribute()
    {
        $this->attributes['updated_by'] = Auth::user()->getUserFullName();
    }
}
