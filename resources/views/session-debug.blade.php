<!DOCTYPE html>
<html>
<head>
    <title>Session Debug Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .debug-box { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007cba; }
        .success { background: #e8f5e8; border-left-color: #28a745; }
        .error { background: #ffeaea; border-left-color: #dc3545; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        button:hover { background: #005a87; }
    </style>
</head>
<body>
    <h1>Session & Login Debug Test</h1>
    
    <div class="debug-box">
        <h3>📊 Session Information</h3>
        <p><strong>Session ID:</strong> <code>{{ session()->getId() }}</code></p>
        <p><strong>CSRF Token:</strong> <code>{{ csrf_token() }}</code></p>
        <p><strong>Session Driver:</strong> <code>{{ config('session.driver') }}</code></p>
        <p><strong>Current Time:</strong> {{ now() }}</p>
    </div>

    <div class="debug-box {{ Auth::check() ? 'success' : 'error' }}">
        <h3>🔐 Authentication Status</h3>
        @if(Auth::check())
            <p>✅ <strong>Logged In</strong></p>
            <p><strong>User ID:</strong> {{ Auth::user()->id }}</p>
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
            
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
            <a href="/dashboard" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">Go to Dashboard</a>
        @else
            <p>❌ <strong>Not Logged In</strong></p>
        @endif
    </div>

    @if(!Auth::check())
    <div class="debug-box">
        <h3>🚀 Login Test</h3>
        
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach($errors->all() as $error)
                    <div>❌ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="user@demo.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" value="password" required>
            </div>
            <button type="submit">🔑 Login as Regular User</button>
        </form>
        
        <hr style="margin: 20px 0;">
        
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="hidden" name="email" value="admin@demo.com">
            <input type="hidden" name="password" value="password">
            <button type="submit">👑 Login as Admin</button>
        </form>
    </div>
    @endif

    <div class="debug-box">
        <h3>🧪 Session Test Actions</h3>
        <button onclick="testSession()">Test Session Storage</button>
        <button onclick="checkAuth()">Check Auth Status</button>
        <div id="testResults" style="margin-top: 10px;"></div>
    </div>

    <script>
        function testSession() {
            fetch('/test-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ test: 'session_test' })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('testResults').innerHTML = 
                    `<p><strong>Session Test:</strong> ${data.success ? '✅ Working' : '❌ Failed'}</p>
                     <p><strong>Data:</strong> ${JSON.stringify(data)}</p>`;
            })
            .catch(error => {
                document.getElementById('testResults').innerHTML = 
                    `<p style="color: red;"><strong>Error:</strong> ${error.message}</p>`;
            });
        }

        function checkAuth() {
            fetch('/check-auth', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('testResults').innerHTML = 
                    `<p><strong>Auth Check:</strong> ${data.authenticated ? '✅ Authenticated' : '❌ Not Authenticated'}</p>
                     <p><strong>User:</strong> ${data.user ? data.user.email : 'None'}</p>`;
            })
            .catch(error => {
                document.getElementById('testResults').innerHTML = 
                    `<p style="color: red;"><strong>Error:</strong> ${error.message}</p>`;
            });
        }
    </script>
</body>
</html>