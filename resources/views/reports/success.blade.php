<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Submitted Successfully</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 2rem; display: flex; justify-content: center; }
        .success-card { background: white; padding: 3rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
        .tracking-box { background: #fef3c7; border: 2px dashed #d97706; padding: 1.5rem; margin: 1.5rem 0; font-size: 1.5rem; font-family: monospace; font-weight: bold; color: #92400e; letter-spacing: 2px; }
        .warning-text { color: #dc2626; font-weight: bold; font-size: 0.9rem; }
        .info-text { margin-top: 1.5rem; font-size: 0.95rem; color: #4b5563; line-height: 1.5; }
        .btn { display: inline-block; background-color: #3b82f6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: bold; margin-top: 2rem; }
    </style>
</head>
<body>

    <div class="success-card">
        <h2 style="color: #16a34a; margin-top: 0;">Report Submitted Securely</h2>
        
        <p>Your report has been successfully recorded. Please save your Tracking ID below.</p>

        <div class="tracking-box">
            {{ session('tracking_id') }}
        </div>

        <p class="warning-text">Write this down along with your 6-digit passcode. You cannot recover them if lost.</p>

        <div class="info-text">
            <strong>What happens next?</strong><br>
            It typically takes 1 to 3 business days for our administrators to review and respond to new reports. You can use your Tracking ID and passcode to check for updates or follow-up questions from the admin team.
        </div>

        <a href="{{ route('report.create') }}" class="btn">Return to Homepage</a>
    </div>

</body>
</html>