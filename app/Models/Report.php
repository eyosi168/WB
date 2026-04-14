<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // 1. SECURITY: What columns are users allowed to fill?
    protected $fillable = [
        'tracking_id',
        'passcode',
        'bureau_id',
        'category_id',
        'description',
        'status',
        'priority',
    ];

    // 2. THE MAGIC: Automatic hashing and encryption
    protected function casts(): array
    {
        return [
            'passcode' => 'hashed', // Automatically hashes the PIN before saving
            'description' => 'encrypted', // Encrypts the text so database admins can't read it
        ];
    }

    // 3. RELATIONSHhips: How does this connect to other tables?
    public function bureau()
    {
        return $this->belongsTo(Bureau::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    public function messages()
    {
        return $this->hasMany(ReportMessage::class);
    }
}
