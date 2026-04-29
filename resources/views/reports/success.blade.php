<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Submitted Successfully</title>

    <style>
        :root {
            --primary: #8dc33a;
            --secondary: #048ed6;
            --bg: #f3f4f6;
            --text: #1f2937;
            --border: #d1d5db;
        }

        body {
            font-family: sans-serif;
            background-color: var(--bg);
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        .success-card {
            background: white;
            padding: 3rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 520px;
            width: 100%;
        }

        .logo {
            margin-bottom: 1.5rem;
        }

        .logo img {
            height: 60px;
            object-fit: contain;
        }

        h2 {
            color: var(--primary);
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        .tracking-box {
            background: #ecfdf5;
            border: 2px dashed var(--primary);
            padding: 1.5rem;
            margin: 1.5rem 0;
            font-size: 1.6rem;
            font-family: monospace;
            font-weight: bold;
            color: #166534;
            letter-spacing: 2px;
            border-radius: 8px;
        }

        .warning-text {
            color: #dc2626;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .info-text {
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: #4b5563;
            line-height: 1.6;
            text-align: left;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .btn {
            display: inline-block;
            background-color: var(--secondary);
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 2rem;
            transition: background 0.2s;
        }

        .btn:hover {
            background-color: #037bb8;
        }

        .success-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    <div class="success-card">

        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
        </div>

        <div class="success-icon">✅</div>

        <h2>Report Submitted Securely</h2>

        <p style="color:#6b7280;">
            Your report has been successfully recorded. Please save your Tracking ID below.
        </p>

        <div class="tracking-box">
            {{ session('tracking_id') }}
        </div>

        <p class="warning-text">
            ⚠️ Save this Tracking ID and your 6-digit passcode. They cannot be recovered if lost.
        </p>

        <div class="info-text">
            <strong>What happens next?</strong><br><br>
            Your report will be reviewed by the responsible team within <strong>1–3 business days</strong>.<br><br>
            You can use your Tracking ID and passcode anytime to:
            <ul style="margin-top:0.5rem;">
                <li>Check status updates</li>
                <li>View admin responses</li>
                <li>Submit follow-ups</li>
            </ul>
        </div>

        <a href="{{ route('report.create') }}" class="btn">
            Return to Homepage
        </a>

    </div>

</body>
</html>