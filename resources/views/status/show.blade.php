<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Portal - {{ $report->tracker->tracking_id ?? 'Report' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-50">

    <!-- NAVBAR -->
    <div class="w-full shadow-md bg-white">
        <div class="max-w-5xl mx-auto px-6 h-20 flex justify-between items-center">

            <div class="flex items-center gap-8 -ml-2">

                <!-- PROPERLY BIGGER LOGO -->
                <img src="{{ asset('images/logo.jpg') }}"
                     alt="Logo"
                     class="h-14 w-auto object-contain">

                <h1 class="text-2xl font-bold text-[#048cd6] tracking-tight">
                    Secure Portal
                </h1>
            </div>

            <form action="{{ route('report.status.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-[#8cc33b] text-white px-6 py-2.5 rounded-md font-semibold hover:bg-opacity-90 transition shadow-sm">
                    Secure Logout
                </button>
            </form>

        </div>
    </div>

    <!-- MAIN -->
    <div class="max-w-5xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- SIDEBAR -->
            <div class="md:col-span-1 space-y-6">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 sticky top-6">
                    <h3 class="font-bold text-lg border-b pb-3 mb-4 text-[#048cd6]">
                        Report Info
                    </h3>

                    <p class="mb-4">
                        <strong>Status:</strong><br>
                        <span class="inline-block mt-1 bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm font-bold uppercase border border-yellow-200">
                            {{ $report->status }}
                        </span>
                    </p>

                    <p class="mb-4">
                        <strong>Department:</strong><br>
                        <span class="text-gray-700">{{ $report->bureau->name }}</span>
                    </p>

                    <p class="mb-4">
                        <strong>Category:</strong><br>
                        <span class="text-gray-700">{{ $report->category->name }}</span>
                    </p>

                    <p>
                        <strong>Location:</strong><br>
                        <span class="text-gray-700">
                            {{ $report->address ?? 'Not provided' }}
                        </span>
                    </p>
                </div>

            </div>

            <!-- MAIN AREA -->
            <div class="md:col-span-2 space-y-6">

                <!-- INITIAL REPORT -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg mb-4 text-[#048cd6]">
                        Your Initial Report
                    </h3>

                    <p class="text-gray-700 whitespace-pre-wrap mb-6">
                        {{ $report->description }}
                    </p>

                    @if($report->attachments && $report->attachments->count() > 0)
                        <h4 class="font-semibold text-sm text-gray-500 mb-2">
                            Attached Evidence:
                        </h4>

                        <div class="flex flex-wrap gap-3">
                            @foreach($report->attachments as $file)
                                <a href="{{ Storage::disk('s3')->temporaryUrl($file->file_path, now()->addMinutes(15)) }}"
                                   target="_blank"
                                   class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-md text-sm text-[#048cd6] hover:bg-gray-200 transition">
                                    
                                    📎 {{ $file->file_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- CHAT -->
                <div id="chat-wrapper">
                    @livewire('reporter-chat-box', ['report' => $report])
                </div>

            </div>

        </div>
    </div>

    @livewireScripts

    <!-- REAL AUTOSCROLL (last message targeting) -->
    <script>
        function scrollToLastMessage() {
            const wrapper = document.getElementById('chat-wrapper');
            if (!wrapper) return;

            // target last message bubble
            const lastMessage = wrapper.querySelector('[class*="p-4"]:last-child');

            if (lastMessage) {
                lastMessage.scrollIntoView({
                    behavior: "smooth",
                    block: "end"
                });
            }
        }

        // initial
        window.addEventListener('load', scrollToLastMessage);

        // livewire update
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', () => {
                setTimeout(scrollToLastMessage, 50);
            });
        });
    </script>

</body>
</html>