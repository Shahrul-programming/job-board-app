<!DOCTYPE html>
<html>
<head>
    <title>CSRF Test - Debug Mode</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>CSRF Token Debug Test</h1>
    
    <div class="section">
        <h3>Current Session Info</h3>
        <p><strong>CSRF Token:</strong> <code>{{ csrf_token() }}</code></p>
        <p><strong>Session ID:</strong> <code>{{ session()->getId() }}</code></p>
        <p><strong>Auth Status:</strong> {{ Auth::check() ? 'Logged In as ' . Auth::user()->email : 'Guest' }}</p>
        <p><strong>Current Time:</strong> {{ now() }}</p>
    </div>

    @if(!Auth::check())
    <div class="section">
        <h3>1. Login Test</h3>
        <form method="POST" action="/login">
            @csrf
            <div>
                <label>Email:</label>
                <input type="email" name="email" value="user@demo.com" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" value="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    @else
    <div class="section">
        <h3>✓ Logged in as: {{ Auth::user()->email }}</h3>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
    @endif
    
    <div class="section">
        <h3>2. Test CSRF-Protected Request</h3>
        <button onclick="testCsrfRequest()">Test CSRF Protected Route</button>
        <div id="csrfResult"></div>
    </div>

    <div class="section">
        <h3>3. Test Token Refresh</h3>
        <button onclick="refreshToken()">Refresh CSRF Token</button>
        <div id="tokenResult"></div>
    </div>

    <div class="section">
        <h3>4. Debug Console</h3>
        <div id="debugConsole" style="background: #f5f5f5; padding: 10px; max-height: 200px; overflow-y: auto;">
            <p>Debug messages will appear here...</p>
        </div>
    </div>

    <script>
        const debug = (message) => {
            const console = document.getElementById('debugConsole');
            const p = document.createElement('p');
            p.innerHTML = `[${new Date().toLocaleTimeString()}] ${message}`;
            console.appendChild(p);
            console.scrollTop = console.scrollHeight;
        };

        // Setup CSRF token
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        debug(`Initial CSRF token: ${window.csrfToken}`);

        function testCsrfRequest() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            debug(`Testing with token: ${token}`);
            
            fetch('/test-csrf-protected', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ test: true })
            })
            .then(response => {
                debug(`Response status: ${response.status}`);
                if (response.status === 419) {
                    debug('❌ CSRF Token Mismatch (419 error)');
                    document.getElementById('csrfResult').innerHTML = '<span class="error">❌ CSRF Error 419</span>';
                } else if (response.ok) {
                    debug('✅ CSRF Token Valid');
                    document.getElementById('csrfResult').innerHTML = '<span class="success">✅ CSRF Token Valid</span>';
                } else {
                    debug(`❓ Other response: ${response.status}`);
                    document.getElementById('csrfResult').innerHTML = `<span class="info">Response: ${response.status}</span>`;
                }
                return response.text();
            })
            .catch(error => {
                debug(`❌ Fetch error: ${error.message}`);
                document.getElementById('csrfResult').innerHTML = `<span class="error">Error: ${error.message}</span>`;
            });
        }

        function refreshToken() {
            fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const newToken = data.csrf_token;
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);
                window.csrfToken = newToken;
                debug(`✅ Token refreshed: ${newToken}`);
                document.getElementById('tokenResult').innerHTML = `<span class="success">✅ New token: ${newToken}</span>`;
            })
            .catch(error => {
                debug(`❌ Token refresh error: ${error.message}`);
                document.getElementById('tokenResult').innerHTML = `<span class="error">Error: ${error.message}</span>`;
            });
        }

        // Auto-test after login redirect
        @if(Auth::check() && request()->get('test_after_login'))
            debug('🔄 Auto-testing after login...');
            setTimeout(() => {
                testCsrfRequest();
            }, 1000);
        @endif
    </script>
</body>
</html>