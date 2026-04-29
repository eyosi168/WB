<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bureau extends Model
{
    protected $fillable = ['parent_id', 'name', 'level_type'];

    // Gets the parent of this bureau (e.g., gets Information System for Software Development)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Bureau::class, 'parent_id');
    }

    // Gets the sub-bureaus under this one
    public function children(): HasMany
    {
        return $this->hasMany(Bureau::class, 'parent_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
    
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}