<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
</head>
<body>
    <h1>Test Authentication System</h1>
    
    <div style="border:1px solid #ccc; padding:20px; margin:20px 0;">
        <h2>Current User Status</h2>
        <div id="auth-status">Loading...</div>
    </div>
    
    <div style="border:1px solid #ccc; padding:20px; margin:20px 0;">
        <h2>Login Test</h2>
        <form id="login-form">
            <label>Email:</label><br>
            <input type="email" name="email" value="user@demo.com" required><br><br>
            
            <label>Password:</label><br>
            <input type="password" name="password" value="password" required><br><br>
            
            <button type="submit">Login</button>
        </form>
        
        <div id="login-result" style="margin-top: 20px;"></div>
    </div>
    
    <script>
    // Check auth status
    fetch('/session-debug')
        .then(response => response.text())
        .then(data => {
            document.getElementById('auth-status').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('auth-status').innerHTML = 'Error: ' + error;
        });
        
    // Handle login form
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const resultDiv = document.getElementById('login-result');
        resultDiv.innerHTML = 'Logging in...';
        
        try {
            // Get CSRF token first
            const tokenResponse = await fetch('/');
            const tokenText = await tokenResponse.text();
            const tokenMatch = tokenText.match(/name="csrf-token" content="([^"]+)"/);
            const csrfToken = tokenMatch ? tokenMatch[1] : null;
            
            if (!csrfToken) {
                throw new Error('Could not get CSRF token');
            }
            
            // Attempt login
            const formData = new FormData(this);
            formData.append('_token', csrfToken);
            
            const response = await fetch('/login', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                redirect: 'manual'
            });
            
            if (response.type === 'opaqueredirect' || response.status === 302) {
                resultDiv.innerHTML = 'Login successful! Redirected.';
                // Check auth status again
                setTimeout(() => {
                    fetch('/session-debug')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('auth-status').innerHTML = data;
                        });
                }, 500);
            } else {
                const responseText = await response.text();
                resultDiv.innerHTML = 'Response: ' + response.status + '<br>' + responseText.substring(0, 500);
            }
            
        } catch (error) {
            resultDiv.innerHTML = 'Error: ' + error.message;
        }
    });
    </script>
</body>
</html>