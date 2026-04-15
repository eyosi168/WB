<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTracker extends Model
{
    protected $fillable = ['report_id', 'tracking_id', 'passcode'];

    protected function casts(): array
    {
        return [
            'passcode' => 'hashed', // Magic: Auto-hashes the PIN
        ];
    }

    public function report() { return $this->belongsTo(Report::class); }
}