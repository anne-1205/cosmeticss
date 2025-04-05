<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HM Cosmetics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff69b4;
            --secondary-color: #ffc0cb;
            --accent-color: #fff0f5;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: url('{{ asset("images/loginbg.jpg") }}') center/cover no-repeat; /* Changed to image background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Add a semi-transparent overlay to ensure form readability */
        .login-container {
            background: rgba(255, 255, 255, 0.95); /* Made container slightly transparent */
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); /* Enhanced shadow for better contrast */
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(5px); /* Optional: adds subtle blur behind the container */
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
        }

        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 2px solid #eee;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255,105,180,0.25);
        }

        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #ff4fa7;
            transform: translateY(-2px);
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .remember-me {
            color: #666;
        }

        .remember-me input[type="checkbox"] {
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" 
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" 
                    placeholder="Password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-login">Sign In</button>

            <div class="text-center mt-3">
                <p>Don't have an account? <a href="{{ route('register') }}" class="forgot-password">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
