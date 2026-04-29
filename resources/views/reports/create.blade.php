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
        .form-container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
        input, select, textarea { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .hierarchy-select { margin-bottom: 10px; }
        button[type="submit"] { background-color: #ef4444; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; font-size: 1rem; }
        .help-text { font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem; }
        .error-msg { color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; }
    </style>
</head>
<body>

    <div class="header-actions">
        <a href="{{ route('report.status.index') }}" class="status-btn">Check Report Status &rarr;</a>
    </div>

    <div class="form-container">
        <h2>Submit a Secure Report</h2>
        <p>Your identity remains anonymous. Please follow the hierarchy to select the correct office.</p>

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Target Bureau / Department *</label>
                
                <select id="level_1" class="hierarchy-select">
                    <option value="">-- Select Organization (e.g. Ethio Telecom) --</option>
                    @foreach($bureaus->where('parent_id', null) as $bureau)
                        <option value="{{ $bureau->id }}">{{ $bureau->name }}</option>
                    @endforeach
                </select>

                <select id="level_2" class="hierarchy-select" style="display:none;">
                    <option value="">-- Select Division --</option>
                </select>

                <select id="level_3" class="hierarchy-select" style="display:none;">
                    <option value="">-- Select Department --</option>
                </select>

                <select id="level_4" class="hierarchy-select" style="display:none;">
                    <option value="">-- Select Section --</option>
                </select>

                <input type="hidden" name="bureau_id" id="bureau_id" value="{{ old('bureau_id') }}">
                
                @error('bureau_id') <div class="error-msg">Please select at least the organization.</div> @enderror
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
                <label for="address">Specific Location (Optional)</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="e.g., HQ, 4th Floor">
            </div>

            <div class="form-group">
                <label for="description">Detailed Description *</label>
                <textarea name="description" id="description" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="evidence">Attach Evidence</label>
                <input type="file" name="evidence[]" id="evidence" multiple>
            </div>

            <div class="form-group">
                <label for="passcode">6-Digit Passcode *</label>
                <input type="password" name="passcode" id="passcode" required pattern="\d{6}" maxlength="6">
            </div>

            <button type="submit">Submit Report</button>
        </form>
    </div>

    <script>
        const allBureaus = @json($bureaus);
        const levels = [
            document.getElementById('level_1'),
            document.getElementById('level_2'),
            document.getElementById('level_3'),
            document.getElementById('level_4')
        ];
        const hiddenInput = document.getElementById('bureau_id');

        function updateDropdowns(index) {
            const selectedId = levels[index].value;

            // 1. Update the hidden input with the current selection
            // If the user clears a dropdown, we revert to the parent ID
            if (selectedId) {
                hiddenInput.value = selectedId;
            } else {
                hiddenInput.value = (index > 0) ? levels[index - 1].value : "";
            }

            // 2. Reset all dropdowns below this one
            for (let i = index + 1; i < levels.length; i++) {
                levels[i].style.display = 'none';
                levels[i].innerHTML = '<option value="">-- Select --</option>';
            }

            // 3. Find children of the selected bureau
            if (selectedId) {
                const children = allBureaus.filter(b => b.parent_id == selectedId);
                
                if (children.length > 0 && index + 1 < levels.length) {
                    const nextLevel = levels[index + 1];
                    nextLevel.style.display = 'block';
                    
                    children.forEach(child => {
                        const opt = document.createElement('option');
                        opt.value = child.id;
                        opt.textContent = child.name;
                        nextLevel.appendChild(opt);
                    });
                }
            }
        }

        // Attach listeners
        levels.forEach((el, index) => {
            el.addEventListener('change', () => updateDropdowns(index));
        });
    </script>
</body>
</html>