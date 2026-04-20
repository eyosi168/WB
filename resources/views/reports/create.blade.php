<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Report</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 2rem; }
        .header-actions { max-width: 600px; margin: 0 auto 1rem auto; text-align: right; }
        .status-btn { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 0.9rem; }
        .status-btn:hover { background-color: #2563eb; }
        .form-container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
        input, select, textarea { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button[type="submit"] { background-color: #ef4444; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; font-size: 1rem; }
        button[type="submit"]:hover { background-color: #dc2626; }
        .help-text { font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem; }
        .error-msg { color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; }
    </style>
</head>
<body>

    <div class="header-actions">
        <a href="{{ route('report.status.index') }}" class="status-btn">Check Report Status & Follow Ups &rarr;</a>
        <!-- <a href="/status" class="status-btn">Check Report Status & Follow Ups &rarr;</a> -->
    </div>

    <div class="form-container">
        <h2>Submit a Secure Report</h2>
        <p>Your identity will remain completely anonymous. Please save the tracking ID provided after submission.</p>

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="bureau_id">Which Bureau/Department does this concern? *</label>
                <select name="bureau_id" id="bureau_id" required>
                    <option value="">-- Select a Bureau --</option>
                    @foreach($bureaus as $bureau)
                        <option value="{{ $bureau->id }}" {{ old('bureau_id') == $bureau->id ? 'selected' : '' }}>{{ $bureau->name }}</option>
                    @endforeach
                </select>
                @error('bureau_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Incident Category *</label>
                <select name="category_id" id="category_id" required>
                    <option value="">-- Select a Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="address">Specific Location / Address (Optional)</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="e.g., 3rd Floor Breakroom">
            </div>

            <div class="form-group">
                <label for="description">Detailed Description *</label>
                <textarea name="description" id="description" rows="5" required placeholder="Describe what happened...">{{ old('description') }}</textarea>
                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="evidence">Attach Evidence (Optional)</label>
                <input type="file" name="evidence[]" id="evidence" multiple>
                <div class="help-text">You can upload multiple files (images, PDFs, etc.) up to 10MB each.</div>
                @error('evidence.*') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <hr style="margin: 2rem 0; border-top: 1px solid #e5e7eb;">

            <div class="form-group">
                <label for="passcode">Create a 6-Digit Passcode *</label>
                <input type="password" name="passcode" id="passcode" required pattern="\d{6}" maxlength="6" placeholder="e.g. 123456">
                <div class="help-text">You will need this passcode AND your tracking ID to check for updates. Do not forget it.</div>
                @error('passcode') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Submit Report</button>
        </form>
    </div>

</body>
</html>