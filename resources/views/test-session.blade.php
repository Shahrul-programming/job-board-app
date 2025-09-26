<!DOCTYPE html>
<html>
<head>
    <title>CSRF & Session Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; }
        .info { background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 5px; }
        form { margin: 10px 0; }
        input, button { padding: 8px 12px; margin: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; cursor: pointer; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔒 CSRF & Session Test</h1>
        
        @if(session('error'))
            <div class="error">❌ {{ session('error') }}</div>
        @endif
        
        @if(session('success'))
            <div class="success">✅ {{ session('success') }}</div>
        @endif
        
        <div class="section">
            <h2>Authentication Status</h2>
            @if(auth()->check())
                <div class="success">✅ Logged in as: {{ auth()->user()->email }} ({{ auth()->user()->role }})</div>
                <p>User ID: {{ auth()->user()->id }}</p>
            @else
                <div class="error">❌ Not logged in</div>
            @endif
        </div>
        
        <div class="section">
            <h2>Session Information</h2>
            <div class="info">
                <strong>Session ID:</strong> {{ session()->getId() }}<br>
                <strong>CSRF Token:</strong> {{ csrf_token() }}<br>
                <strong>Session Token:</strong> {{ session()->token() }}<br>
                <strong>Session Started:</strong> {{ session()->isStarted() ? 'Yes' : 'No' }}<br>
                <strong>Current Time:</strong> {{ now() }}
            </div>
        </div>
        
        <div class="section">
            <h2>Quick Actions</h2>
            
            @if(!auth()->check())
                <form method="POST" action="/login">
                    @csrf
                    <h3>Quick Login</h3>
                    <input type="email" name="email" value="user@demo.com" required>
                    <input type="password" name="password" value="password" required>
                    <button type="submit">Login</button>
                </form>
            @else
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
                <a href="/dashboard" style="display: inline-block; padding: 8px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin: 5px;">Dashboard</a>
            @endif
            
            <form method="POST" action="/test-session">
                @csrf
                <h3>CSRF Test</h3>
                <input type="text" name="test_field" placeholder="Enter test data" required>
                <button type="submit">Submit Test</button>
            </form>
        </div>
        
        <div class="section">
            <h2>Request Info</h2>
            <p><strong>URL:</strong> {{ request()->fullUrl() }}</p>
            <p><strong>Method:</strong> {{ request()->method() }}</p>
            <p><strong>IP:</strong> {{ request()->ip() }}</p>
            <p><strong>User Agent:</strong> {{ substr(request()->userAgent(), 0, 100) }}...</p>
        </div>
        
        <div class="section">
            <h2>All Session Data</h2>
            <pre>{{ json_encode(session()->all(), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
    
    <script>
        console.log('CSRF Token:', '{{ csrf_token() }}');
        console.log('Meta CSRF:', document.querySelector('meta[name="csrf-token"]')?.content);
    </script>
</body>
</html>