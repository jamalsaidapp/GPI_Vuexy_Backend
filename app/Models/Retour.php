<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;
use Wildside\Userstamps\Userstamps;

class Retour extends Pivot
{
    use HasFactory, Userstamps;

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'affected_at' => 'datetime:d/m/Y',
        'rendu_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',

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
