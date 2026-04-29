<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Secure Report</title>
    <style>
        :root {
            --primary: #8dc33a;
    --secondary: #048ed6;
    --bg: #f3f4f6;
    --text: #1f2937;
    --border: #d1d5db;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text); padding: 2rem; }
        
        .header-actions { max-width: 650px; margin: 0 auto 1rem auto; text-align: right; }
        .status-btn { background-color: #3b82f6; color: white; padding: 0.6rem 1.2rem; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 0.9rem; transition: background 0.2s; }
        .status-btn:hover { background-color: #2563eb; }

        .form-container { max-width: 650px; margin: auto; background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        
        h2 { font-size: 1.5rem; margin-top: 0; margin-bottom: 0.5rem; color: #111827; }
        .subtitle { color: #6b7280; font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.4; }

        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 0.5rem; color: #374151; }
        
        input, select, textarea { 
            width: 100%; padding: 0.75rem; border: 1px solid var(--border); 
            border-radius: 6px; box-sizing: border-box; font-size: 0.95rem;
        }
        input:focus, select:focus, textarea:focus { 
            outline: none; border-color: var(--primary); ring: 2px solid rgba(239, 68, 68, 0.2); 
        }

        /* --- MODERN HIERARCHY STYLING --- */
        .hierarchy-wrapper {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .path-preview {
            background: white;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            border-left: 4px solid var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .level-box {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 1.2rem;
        }

        /* The vertical spine */
        .level-box::before {
            content: '';
            position: absolute;
            left: 0;
            top: -10px;
            bottom: 25px;
            width: 2px;
            background: #d1d5db;
        }

        .step-tag {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            display: block;
            margin-bottom: 0.3rem;
        }

        button[type="submit"] { 
            background-color: var(--primary); color: white; padding: 1rem; 
            border: none; border-radius: 6px; cursor: pointer; font-weight: bold; 
            width: 100%; font-size: 1.1rem; margin-top: 1rem; transition: background 0.2s;
        }
        button[type="submit"]:hover { background-color: #dc2626; }
        .status-btn {
    background-color: var(--secondary);
}
.status-btn:hover {
    background-color: #037bb8;
}

button[type="submit"] {
    background-color: var(--primary);
}
button[type="submit"]:hover {
    background-color: #7ab82f;
}
        
        .help-text { font-size: 0.8rem; color: #6b7280; margin-top: 0.4rem; line-height: 1.4; }
        .error-msg { color: var(--primary); font-size: 0.85rem; margin-top: 0.3rem; font-weight: 500; }
    </style>
</head>
<body>

    <div class="header-actions">
        <a href="{{ route('report.status.index') }}" class="status-btn">Check Report Status & Follow Ups &rarr;</a>
    </div>

    <div class="form-container">
    <div style="text-align:center; margin-bottom: 1.5rem;">
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 60px; object-fit: contain;">
</div>
        <h2>Submit a Secure Report</h2>
        <p class="subtitle">Your identity will remain completely anonymous. Please save the tracking ID provided after submission.</p>

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Target Location / Office *</label>
                <div class="hierarchy-wrapper">
                    <div id="path-display" class="path-preview">Select an organization...</div>

                    <div class="level-box" style="padding-left: 0;">
                        <span class="step-tag">Step 1: Organization</span>
                        <select id="level_1" class="hierarchy-select">
                            <option value="">-- Choose Organization --</option>
                            @foreach($bureaus->where('parent_id', null) as $bureau)
                                <option value="{{ $bureau->id }}">{{ $bureau->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="container_2" class="level-box" style="display:none;">
                        <span class="step-tag">Step 2: Division</span>
                        <select id="level_2" class="hierarchy-select"></select>
                    </div>

                    <div id="container_3" class="level-box" style="display:none;">
                        <span class="step-tag">Step 3: Department</span>
                        <select id="level_3" class="hierarchy-select"></select>
                    </div>

                    <div id="container_4" class="level-box" style="display:none;">
                        <span class="step-tag">Step 4: Section</span>
                        <select id="level_4" class="hierarchy-select"></select>
                    </div>

                    <input type="hidden" name="bureau_id" id="bureau_id" value="{{ old('bureau_id') }}">
                </div>
                @error('bureau_id') <div class="error-msg">Please select at least the organization.</div> @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Incident Category *</label>
                <select name="category_id" id="category_id" required>
                    <option value="">-- Select a Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="address">Specific Location / Address (Optional)</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="e.g., 3rd Floor, Office 12">
            </div>

            <div class="form-group">
                <label for="description">Detailed Description *</label>
                <textarea name="description" id="description" rows="5" required placeholder="Provide as much detail as possible...">{{ old('description') }}</textarea>
                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="evidence">Attach Evidence (Optional)</label>
                <input type="file" name="evidence[]" id="evidence" multiple>
                <div class="help-text">Upload images, PDFs, etc. up to 10MB per file.</div>
                @error('evidence.*') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #e5e7eb;">

            <div class="form-group">
                <label for="passcode">Create a 6-Digit Passcode *</label>
                <input type="password" name="passcode" id="passcode" required pattern="\d{6}" maxlength="6" placeholder="e.g. 123456">
                <div class="help-text">Crucial: You will need this passcode AND your tracking ID to check for updates later.</div>
                @error('passcode') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Submit Secure Report</button>
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

    const containers = [
        null,
        document.getElementById('container_2'),
        document.getElementById('container_3'),
        document.getElementById('container_4')
    ];

    const pathDisplay = document.getElementById('path-display');
    const hiddenInput = document.getElementById('bureau_id');

    // ✅ NEW: always pick deepest selected level
    function updateHiddenInput() {
        const selected = levels
            .map(l => l.value)
            .filter(v => v);

        hiddenInput.value = selected.length
            ? selected[selected.length - 1]
            : "";
    }

    function updateBreadcrumbs() {
        let path = [];
        levels.forEach(sel => {
            if (sel.value) {
                path.push(sel.options[sel.selectedIndex].text);
            }
        });

        pathDisplay.innerHTML = path.length > 0
            ? path.join(' <span style="color:#9ca3af; padding:0 5px;">/</span> ')
            : 'Select an organization to start...';
    }

    function handleLevelChange(index) {
        const val = levels[index].value;

        // ❌ removed old hiddenInput logic here

        // Reset child dropdowns
        for (let i = index + 1; i < levels.length; i++) {
            if (containers[i]) containers[i].style.display = 'none';
            levels[i].innerHTML = '<option value="">-- Select --</option>';
        }

        // Show and populate next level
        if (val) {
            const children = allBureaus.filter(b => b.parent_id == val);

            if (children.length > 0 && index + 1 < levels.length) {
                const nextLevel = levels[index + 1];
                const nextContainer = containers[index + 1];

                nextContainer.style.display = 'block';

                children.forEach(child => {
                    const opt = document.createElement('option');
                    opt.value = child.id;
                    opt.textContent = child.name;
                    nextLevel.appendChild(opt);
                });
            }
        }

        // ✅ ALWAYS update after any change
        updateHiddenInput();
        updateBreadcrumbs();
    }

    levels.forEach((el, index) => {
        el.addEventListener('change', () => handleLevelChange(index));
    });
</script>
</body>
</html>