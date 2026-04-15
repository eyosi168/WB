<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Removed tracking_id and passcode. Added bureau_id and category_id.
    protected $fillable = [
        'bureau_id',
        'category_id',
        'description',
        'status',
        'priority',
    ];

    protected function casts(): array
    {
        return [
            'description' => 'encrypted', 
        ];
    }

    // --- Relationships ---
    public function bureau() { return $this->belongsTo(Bureau::class); }
    public function category() { return $this->belongsTo(Category::class); }
    
    public function tracker() { return $this->hasOne(ReportTracker::class); }
    public function attachments() { return $this->hasMany(ReportAttachment::class); }
    public function messages() { return $this->hasMany(ReportMessage::class); }
}