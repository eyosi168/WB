<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['name', 'email', 'password','bureau_id',])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles; //
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     * 
     */
    public function bureau(): BelongsTo
    {
        return $this->belongsTo(Bureau::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function reports(): HasMany
{
    // This tells Laravel: Find all reports where 'claimed_by' matches this user's ID
    return $this->hasMany(Report::class, 'claimed_by');
}
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
