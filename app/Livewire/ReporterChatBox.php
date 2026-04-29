<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReporterChatBox extends Component
{
    use WithFileUploads;

    public Report $report;
    public string $newMessage = '';
    public $attachment;

    protected $rules = [
        'newMessage' => 'nullable|string',
        'attachment' => 'nullable|file|max:10240', // 10MB
    ];

    public function mount(Report $report)
    {
        $this->report = $report;
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage)) && !$this->attachment) return;

        $path = null;
        if ($this->attachment) {
            // Upload to MinIO
            $path = $this->attachment->store('chat-attachments', 's3');
        }

        $this->report->messages()->create([
            'sender_type' => 'reporter',
            'message' => $this->newMessage,
            'attachment_path' => $path,
        ]);

        $this->reset(['newMessage', 'attachment']);
    }

    public function render()
    {
        return view('livewire.reporter-chat-box', [
            'messages' => $this->report->messages()
                ->orderBy('created_at', 'asc')
                ->get(),
        ]);
    }
}