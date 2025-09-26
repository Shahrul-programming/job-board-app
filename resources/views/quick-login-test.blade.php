<!DOCTYPE html>
<html>
<head>
    <title>Quick Login Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #005a87; }
        .success { color: green; padding: 10px; background: #e8f5e8; border-radius: 4px; }
        .error { color: red; padding: 10px; background: #ffeaea; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Login Test Page</h1>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(Auth::check())
        <div class="success">
            <h2>✅ Login Successful!</h2>
            <p><strong>User:</strong> {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
            <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    @else
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
            <button type="submit">Login</button>
        </form>
        
        <hr style="margin: 30px 0;">
        
        <h3>Available Test Accounts:</h3>
        <ul>
            <li><strong>Regular User:</strong> user@demo.com / password</li>
            <li><strong>Admin User:</strong> admin@demo.com / password</li>
        </ul>
    @endif
</body>
</html>