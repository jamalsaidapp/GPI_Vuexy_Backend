<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;
use Wildside\Userstamps\Userstamps;

class Affectation  extends Pivot
{
    use HasFactory, Userstamps;

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'affected_at' => 'datetime:Y-m-d',
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
