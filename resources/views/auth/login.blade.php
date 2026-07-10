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
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #111827;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Modern Dashboard Background Animation */
        .background-grid {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(to right, #e5e7eb 1px, transparent 1px),
                linear-gradient(to bottom, #e5e7eb 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -2;
            opacity: 0.6;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translateY(0); }
            100% { transform: translateY(50px); }
        }

        .login-wrapper {
            display: flex;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 900px;
            min-height: 550px;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            margin: 2rem;
        }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Left Side: Form */
        .login-left {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: #3b82f6;
            border-radius: 1rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
        }

        .login-logo i {
            font-size: 28px;
            color: white;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
            color: #111827;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
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
            color: #9ca3af;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            padding: 0.875rem 1rem 0.875rem 3rem;
            color: #111827;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background: white;
        }

        .form-input:focus + .input-icon {
            color: #3b82f6;
        }

        .btn-login {
            width: 100%;
            background: #3b82f6;
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
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #ef4444;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Right Side: Showcase */
        .login-right {
            flex: 1;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            border-left: 1px solid #e5e7eb;
        }
        
        /* Showcase Decorative circle */
        /* Circle removed per request */

        .animated-widget {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 1.25rem;
            width: 100%;
            max-width: 320px;
            z-index: 1;
            margin-bottom: 1.5rem;
        }

        .widget-1 {
            transform: translateX(-15px);
            animation: float-small 6s ease-in-out infinite;
        }

        .widget-2 {
            transform: translateX(15px);
            animation: float-small 7s ease-in-out infinite reverse;
            margin-bottom: 0;
        }
        
        @keyframes float-small {
            0% { transform: translate(var(--tx), 0px); }
            50% { transform: translate(var(--tx), -10px); }
            100% { transform: translate(var(--tx), 0px); }
        }

        .pulse-dot {
            width: 10px; height: 10px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        @keyframes barMove {
            0% { transform: scaleY(0.3); transform-origin: bottom; }
            100% { transform: scaleY(1); transform-origin: bottom; }
        }
        @keyframes pingLine {
            0% { width: 0%; opacity: 1;}
            100% { width: 100%; opacity: 0; }
        }
        
        @keyframes loading-progress {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .loading-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #3b82f6;
            animation: loading-progress 1.5s infinite linear;
            display: none;
            z-index: 50;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                margin: 1rem;
            }
            .login-right {
                display: none; /* Hide showcase on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="background-grid"></div>
    
    <div class="login-wrapper" style="position: relative;">
        <!-- Loading Bar -->
        <div id="loadingBar" class="loading-bar"></div>
        
        <!-- Left Side: Login Form -->
        <div class="login-left">
            <div class="login-header">
                <div class="login-logo">
                    <i class="ph ph-monitor-play"></i>
                </div>
                <h1 class="login-title">AgentKu</h1>
                <p class="login-subtitle">Akses dasbor pemantauan cerdas</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <i class="ph ph-warning-circle" style="font-size: 1.25rem;"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form id="loginForm" action="{{ route('login') }}" method="POST">
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

                <button type="submit" id="btnSubmit" class="btn-login">
                    <span id="btnText">Masuk Dashboard</span>
                    <i class="ph ph-arrow-right" id="btnIcon"></i>
                </button>
            </form>
        </div>
        
        <!-- Right Side: Showcase -->
        <div class="login-right">
            <!-- Widget Animation 1: Status Server -->
            <div class="animated-widget widget-1" style="--tx: -15px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="ph ph-hard-drives" style="color: #6366f1; font-size: 1.25rem;"></i>
                        <span style="font-size: 0.875rem; font-weight: 600; color: #4b5563;">Server Status</span>
                    </div>
                    <span class="pulse-dot"></span>
                </div>
                <div style="height: 8px; background: #f3f4f6; border-radius: 4px; overflow: hidden; position: relative;">
                    <div style="width: 100%; height: 100%; background: #10b981; position: absolute; top:0; left:0;"></div>
                    <div style="height: 100%; background: rgba(255,255,255,0.8); position: absolute; top:0; left:0; animation: pingLine 2s infinite;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 0.5rem; font-size: 0.75rem; color: #9ca3af;">
                    <span>Latency</span>
                    <span style="color: #10b981; font-weight: 600;">12ms</span>
                </div>
            </div>

            <!-- Widget Animation 2: Activity Chart -->
            <div class="animated-widget widget-2" style="--tx: 15px;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                        <i class="ph ph-activity" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <span style="display: block; font-size: 1.25rem; font-weight: 700; color: #111827;">Live Activity</span>
                        <span style="font-size: 0.75rem; color: #6b7280;">Monitoring 30 agents</span>
                    </div>
                </div>
                <div style="display: flex; gap: 6px; align-items: flex-end; height: 60px;">
                    <div style="flex: 1; height: 30px; background: #e5e7eb; border-radius: 4px; animation: barMove 1s infinite alternate;"></div>
                    <div style="flex: 1; height: 50px; background: #bfdbfe; border-radius: 4px; animation: barMove 1.5s infinite alternate;"></div>
                    <div style="flex: 1; height: 25px; background: #e5e7eb; border-radius: 4px; animation: barMove 1.2s infinite alternate;"></div>
                    <div style="flex: 1; height: 60px; background: #60a5fa; border-radius: 4px; animation: barMove 1.8s infinite alternate;"></div>
                    <div style="flex: 1; height: 45px; background: #3b82f6; border-radius: 4px; animation: barMove 1.1s infinite alternate;"></div>
                    <div style="flex: 1; height: 35px; background: #e5e7eb; border-radius: 4px; animation: barMove 1.4s infinite alternate;"></div>
                </div>
            </div>
            
            <!-- Widget Animation 3: Employee Mini -->
            <div class="animated-widget widget-1" style="--tx: -5px; animation-delay: 1s; margin-top: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 32px; height: 32px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">AF</div>
                    <div style="flex: 1;">
                        <span style="display: block; font-size: 0.875rem; font-weight: 600; color: #111827;">Ahmad Fauzi</span>
                        <span style="display: block; font-size: 0.7rem; color: #6b7280;">VS Code</span>
                    </div>
                    <span class="pulse-dot" style="width: 8px; height: 8px;"></span>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            // Show loading bar
            document.getElementById('loadingBar').style.display = 'block';
            
            // Change button state
            const btn = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            
            btn.style.opacity = '0.7';
            btn.style.cursor = 'wait';
            btnText.innerText = 'Memproses...';
            
            // Swap icon to spinner
            btnIcon.classList.remove('ph-arrow-right');
            btnIcon.classList.add('ph-spinner');
            btnIcon.style.animation = 'spin 1s linear infinite';
            
            // Disable button slightly after to allow form to submit
            setTimeout(() => {
                btn.disabled = true;
            }, 10);
        });
    </script>
    
    <style>
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>
</body>
</html>
