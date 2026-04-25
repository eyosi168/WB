<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Portal - {{ $report->tracker->tracking_id ?? 'Report' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto p-6 mt-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Your Secure Portal</h1>
            <form action="{{ route('report.status.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Secure Logout</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg border-b pb-2 mb-4">Report Info</h3>
                    <p class="mb-2"><strong>Status:</strong> 
                        <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm uppercase">{{ $report->status }}</span>
                    </p>
                    <p class="mb-2"><strong>Department:</strong> <br> {{ $report->bureau->name }}</p>
                    <p class="mb-2"><strong>Category:</strong> <br> {{ $report->category->name }}</p>
                    <p><strong>Location:</strong> <br> {{ $report->address ?? 'Not provided' }}</p>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg border-b pb-2 mb-4">Your Initial Report</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $report->description }}</p>
                </div>

                <!-- <div class="bg-white p-6 rounded-lg shadow border-2 border-dashed border-blue-300">
                    <h3 class="font-bold text-lg mb-4 text-blue-800">Follow-Up Messages (Coming Soon)</h3>
                    
                    <div class="bg-gray-50 p-4 rounded mb-4">
                        <p class="text-sm text-gray-500 font-bold mb-1">Admin - Yesterday</p>
                        <p>Thank you for your report. Could you provide a photo of the incident area?</p>
                    </div>

                    <div class="mt-4 border-t pt-4">
                        <textarea class="w-full p-2 border rounded mb-2 bg-gray-100" rows="3" disabled placeholder="Reply feature under construction..."></textarea>
                        <div class="flex justify-between items-center">
                            <input type="file" disabled class="text-sm text-gray-500">
                            <button disabled class="bg-blue-300 text-white px-4 py-2 rounded cursor-not-allowed">Send Reply</button>
                        </div>
                    </div>
                </div> -->
                <livewire:reporter-chat-box :report="$report" />


            </div>
        </div>
    </div>

</body>
</html>