<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Report Status</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #8dc33a;
            --secondary: #048ed6;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-200">

        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.jpg') }}" class="h-14 mx-auto" alt="Logo">
        </div>

        <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">
            Secure Report Access
        </h2>

        <p class="text-center text-sm text-gray-500 mb-6">
            Enter your Tracking ID and passcode to view updates
        </p>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('report.status.auth') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Tracking ID -->
            <div>
                <label class="block font-semibold mb-1 text-gray-700">
                    Tracking ID
                </label>
                <input type="text"
                       name="tracking_id"
                       required
                       placeholder="e.g. WB-8F3A9C"
                       class="w-full p-2 border rounded focus:outline-none focus:border-green-500 uppercase">
            </div>

            <!-- Passcode -->
            <div>
                <label class="block font-semibold mb-1 text-gray-700">
                    6-Digit Passcode
                </label>
                <input type="password"
                       name="passcode"
                       required
                       maxlength="6"
                       pattern="\d{6}"
                       class="w-full p-2 border rounded focus:outline-none focus:border-green-500">
            </div>

            <!-- Button -->
            <button type="submit"
                    class="w-full text-white font-bold py-2 rounded transition"
                    style="background-color: var(--primary);">
                Access Secure Portal
            </button>

            <p class="text-xs text-center text-gray-500 mt-3">
                🔒 Your access is encrypted and anonymous
            </p>
        </form>

    </div>

</body>
</html>