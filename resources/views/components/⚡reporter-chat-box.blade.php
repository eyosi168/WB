<?php

use Livewire\Component;
use App\Models\Report;
use App\Models\ReportMessage;

new class extends Component
{
    // These must be public to be accessible in the Blade view
    public Report $report;
    public string $newMessage = '';

    // This runs when the component is first loaded
    public function mount(Report $report)
    {
        $this->report = $report;
    }

    // Logic to save the message
    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) return;

        $this->report->messages()->create([
            'sender_type' => 'reporter',
            'message' => $this->newMessage,
        ]);

        $this->newMessage = ''; // Clear the textarea after sending
    }

    // This sends data to the Blade view every time it renders/polls
    public function with(): array
    {
        return [
            'messages' => $this->report->messages()
                ->orderBy('created_at', 'asc')
                ->get(),
        ];
    }
};
?>

<div wire:poll.15s class="bg-white p-6 rounded-lg shadow border-2 border-dashed border-blue-300">
    <h3 class="font-bold text-lg mb-4 text-blue-800">Follow-Up Messages</h3>
    
    <div class="space-y-4 mb-4 max-h-64 overflow-y-auto">
        @foreach($messages as $msg)
            <div class="p-4 rounded {{ $msg->sender_type === 'admin' ? 'bg-gray-50' : 'bg-blue-50 text-right' }}">
                <p class="text-sm text-gray-500 font-bold mb-1">
                    {{ ucfirst($msg->sender_type) }} - {{ $msg->created_at->diffForHumans() }}
                </p>
                <p>{{ $msg->message }}</p> 
            </div>
        @endforeach
    </div>

    <div class="mt-4 border-t pt-4">
        <textarea wire:model="newMessage" class="w-full p-2 border rounded mb-2 bg-gray-100" rows="3" placeholder="Type your reply..."></textarea>
        <div class="flex justify-between items-center">
            <input type="file" class="text-sm text-gray-500">
            <button wire:click="sendMessage" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Send Reply
            </button>
        </div>
    </div>
</div>