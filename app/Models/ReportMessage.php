<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportMessage extends Model
{
    // Added 'attachment_path' so Livewire can save the file path to the database
    protected $fillable = [
        'report_id', 
        'sender_type', 
        'message', 
        'attachment_path'
    ];

    protected function casts(): array
    {
        return [
            'message' => 'encrypted',
        ];
    }

    public function report() 
    { 
        return $this->belongsTo(Report::class); 
    }
}