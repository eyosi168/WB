<div> {{-- THE SINGLE ROOT ELEMENT --}}
    <div wire:poll.15s class="bg-white p-6 rounded-lg shadow-sm border-2 border-[#048cd6]">
        <h3 class="font-bold text-lg mb-4 text-[#048cd6]">Follow-Up Messages</h3>
        
        <div class="space-y-4 mb-4 max-h-80 overflow-y-auto pr-2">
            @forelse($messages as $msg)
                <div class="p-4 rounded-lg {{ $msg->sender_type === 'admin' ? 'bg-gray-100 mr-12' : 'bg-[#8cc33b] bg-opacity-20 ml-12 text-right' }}">
                    <p class="text-xs text-gray-500 font-bold mb-1">
                        {{ ucfirst($msg->sender_type) }} - {{ $msg->created_at->diffForHumans() }}
                    </p>
                    <p class="text-gray-800">{{ $msg->message }}</p>
                    
                    @if($msg->attachment_path)
                        <div class="mt-2">
                            <a href="{{ Storage::disk('s3')->temporaryUrl($msg->attachment_path, now()->addMinutes(15)) }}" target="_blank" class="text-xs text-[#048cd6] underline">
                                📎 View Attachment
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-sm italic">No messages yet.</p>
            @endforelse
        </div>

        <div class="mt-4 border-t pt-4">
            {{-- Use wire:model.defer (Livewire 2) or wire:model (Livewire 3) --}}
            <textarea wire:model="newMessage" class="w-full p-3 border rounded-md mb-2 bg-gray-50" rows="3" placeholder="Type your reply..."></textarea>
            
            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <input type="file" wire:model="attachment" class="text-sm">
                    <div wire:loading wire:target="attachment" class="text-xs text-blue-500">Uploading to storage...</div>
                </div>
                
                <button wire:click="sendMessage" wire:loading.attr="disabled" class="bg-[#048cd6] text-white px-6 py-2 rounded-md font-bold">
                    <span wire:loading.remove wire:target="sendMessage">Send Reply</span>
                    <span wire:loading wire:target="sendMessage">Sending...</span>
                </button>
            </div>
        </div>
    </div>
</div> {{-- END ROOT ELEMENT --}}