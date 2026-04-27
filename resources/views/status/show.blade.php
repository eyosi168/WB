<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Portal - {{ $report->tracker->tracking_id ?? 'Report' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <div class="w-full  shadow-md">
        <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-10 w-auto">
                <h1 class="text-2xl font-bold text-#048cd6" >Secure Portal</h1>
            </div>
            <form action="{{ route('report.status.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-[#8cc33b] text-white px-5 py-2 rounded-md font-semibold hover:bg-opacity-90 transition">
                    Secure Logout
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-6 mt-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg border-b pb-2 mb-4 text-[#048cd6]">Report Info</h3>
                    <p class="mb-3"><strong>Status:</strong> 
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-bold uppercase border border-yellow-200">{{ $report->status }}</span>
                    </p>
                    <p class="mb-3"><strong>Department:</strong> <br> <span class="text-gray-700">{{ $report->bureau->name }}</span></p>
                    <p class="mb-3"><strong>Category:</strong> <br> <span class="text-gray-700">{{ $report->category->name }}</span></p>
                    <p><strong>Location:</strong> <br> <span class="text-gray-700">{{ $report->address ?? 'Not provided' }}</span></p>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg border-b pb-2 mb-4 text-[#048cd6]">Your Initial Report</h3>
                    <p class="text-gray-700 whitespace-pre-wrap mb-6">{{ $report->description }}</p>
                    
                    @if($report->attachments && $report->attachments->count() > 0)
                        <h4 class="font-semibold text-sm text-gray-500 mb-2">Attached Evidence:</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach($report->attachments as $file)
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded text-sm text-[#048cd6] hover:bg-gray-200 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    {{ $file->file_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div wire:poll.15s class="bg-white p-6 rounded-lg shadow-sm border-2 border-[#048cd6]">
                    <h3 class="font-bold text-lg mb-4 text-[#048cd6]">Follow-Up Messages</h3>
                    
                    <div class="space-y-4 mb-4 max-h-80 overflow-y-auto pr-2">
                        @forelse($report->messages as $msg)
                            <div class="p-4 rounded-lg {{ $msg->sender_type === 'admin' ? 'bg-gray-100 mr-12' : 'bg-[#8cc33b] bg-opacity-20 ml-12 text-right' }}">
                                <p class="text-xs text-gray-500 font-bold mb-1">
                                    {{ ucfirst($msg->sender_type) }} - {{ $msg->created_at->diffForHumans() }}
                                </p>
                                <p class="text-gray-800">{{ $msg->message }}</p> 
                                
                                @if($msg->attachment_path)
                                    <div class="mt-2 inline-block">
                                        <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="text-xs bg-white border border-gray-300 px-2 py-1 rounded text-[#048cd6] hover:underline flex items-center gap-1">
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
                        <textarea wire:model="newMessage" class="w-full p-3 border rounded-md mb-2 bg-gray-50 focus:ring-[#048cd6] focus:border-[#048cd6]" rows="3" placeholder="Type your reply..."></textarea>
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                <input type="file" wire:model="attachment" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#048cd6] hover:file:bg-blue-100">
                                <span wire:loading wire:target="attachment" class="text-xs text-[#8cc33b] mt-1">Uploading...</span>
                            </div>
                            
                            <button wire:click="sendMessage" class="bg-[#048cd6] text-white px-6 py-2 rounded-md font-bold hover:bg-opacity-90 transition shadow-sm">
                                Send Reply
                            </button>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</body>
</html>