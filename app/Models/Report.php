<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity; // This is the import
use Spatie\Activitylog\LogOptions;

class Report extends Model
{
    // CHANGE THIS LINE: It must match the import above!
    use HasActivity;

    protected $fillable = [
        'bureau_id',
        'address',
        'category_id',
        'description',
        'status',
        'priority',
        'claimed_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status', 
                'priority', 
                'claimed_by', 
                'category_id'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected function casts(): array
    {
        return [
            'description' => 'encrypted', 
        ];
    }

    // --- Relationships ---
    public function bureau() { return $this->belongsTo(Bureau::class); }
    
    public function category() { return $this->belongsTo(Category::class); }
    
    public function investigator() { return $this->belongsTo(User::class, 'claimed_by'); }
    
    public function tracker() { return $this->hasOne(ReportTracker::class); }
    
    public function attachments() { return $this->hasMany(ReportAttachment::class); }
    
    public function messages() { return $this->hasMany(ReportMessage::class); }
}