<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // ADD THIS
use App\Models\Report;

class ReporterChatBox extends Component
{
    use WithFileUploads; // ENABLE FILE UPLOADS

    public Report $report;
    public string $newMessage = '';
    public $attachment; // Variable to hold the file

    public function mount(Report $report)
    {
        $this->report = $report;
    }

    public function sendMessage()
    {
        // Require either a message OR an attachment
        if (empty(trim($this->newMessage)) && !$this->attachment) return;

        $path = null;
        if ($this->attachment) {
            // Store the file in the 'public/chat-attachments' folder
            $path = $this->attachment->store('chat-attachments', 'public');
        }

        $this->report->messages()->create([
            'sender_type' => 'reporter',
            'message' => $this->newMessage,
            'attachment_path' => $path,
        ]);

        // Reset fields
        $this->newMessage = '';
        $this->attachment = null; 
    }

    public function with(): array
    {
        return [
            'messages' => $this->report->messages()
                ->orderBy('created_at', 'asc')
                ->get(),
        ];
    }
    
    public function render()
    {
        return view('livewire.reporter-chat-box'); // Make sure this matches your blade file name
    }
}