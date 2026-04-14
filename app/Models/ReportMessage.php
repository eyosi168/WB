<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportMessage extends Model
{
    protected $fillable = ['report_id', 'sender_type', 'user_id', 'message'];

    // Security: Encrypt the chat message automatically
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
