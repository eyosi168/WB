<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Report Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Check Report Status</h2>
        
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('report.status.auth') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-bold mb-1 text-gray-700">Tracking ID</label>
                <input type="text" name="tracking_id" required placeholder="e.g. WB-8F3A9C" 
                       class="w-full p-2 border rounded uppercase">
            </div>
            <div>
                <label class="block font-bold mb-1 text-gray-700">6-Digit Passcode</label>
                <input type="password" name="passcode" required maxlength="6" pattern="\d{6}" 
                       class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700">
                Access Secure Portal
            </button>
        </form>
    </div>

</body>
</html>