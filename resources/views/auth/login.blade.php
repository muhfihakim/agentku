<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgentKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        /* Decorative background elements */
        .bg-shape {
            position: absolute;
            filter: blur(100px);
            z-index: 0;
            border-radius: 50%;
            animation: float 10s infinite ease-in-out alternate;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: rgba(99, 102, 241, 0.4); /* Indigo */
            top: -100px;
            left: -100px;
        }
        .shape-2 {
            width: 500px;
            height: 500px;
            background: rgba(236, 72, 153, 0.3); /* Pink */
            bottom: -150px;
            right: -100px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        .login-logo i {
            font-size: 32px;
            color: white;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem 0.875rem 3rem;
            color: white;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: rgba(15, 23, 42, 0.8);
        }

        .form-input:focus + .input-icon {
            color: #6366f1;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="ph ph-shield-check"></i>
            </div>
            <h1 class="login-title">AgentKu</h1>
            <p class="login-subtitle">Silakan login untuk melanjutkan</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i class="ph ph-warning-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-input" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                    <i class="ph ph-envelope-simple input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                    <i class="ph ph-lock-key input-icon"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <span>Masuk</span>
                <i class="ph ph-arrow-right"></i>
            </button>
        </form>
    </div>
</body>
</html>
