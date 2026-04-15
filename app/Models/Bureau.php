<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bureau extends Model
{
    protected $fillable = ['name'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
