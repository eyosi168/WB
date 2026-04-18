<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Report</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 2rem; }
        .form-container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
        input, select, textarea { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #ef4444; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #dc2626; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Submit a Secure Report</h2>
        <p>Your identity will remain completely anonymous.</p>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="bureau_id">Which Bureau/Department does this concern?</label>
                <select name="bureau_id" id="bureau_id" required>
                    <option value="">-- Select a Bureau --</option>
                    @foreach($bureaus as $bureau)
                        <option value="{{ $bureau->id }}">{{ $bureau->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Incident Category (e.g., Harassment, Fraud)</label>
                <select name="category_id" id="category_id" required>
                    <option value="">-- Select a Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="address">Specific Location / Address (Optional)</label>
                <input type="text" name="address" id="address" placeholder="e.g., 3rd Floor Breakroom">
            </div>

            <div class="form-group">
                <label for="description">Detailed Description</label>
                <textarea name="description" id="description" rows="5" required placeholder="Describe what happened..."></textarea>
            </div>

            <button type="submit">Continue to Next Step</button>
        </form>
    </div>

</body>
</html>