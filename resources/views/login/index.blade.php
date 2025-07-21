<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelani Fabrics - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Fabric background with single image */
        /* .fabric-bg {

            background-image:

                linear-gradient(45deg, rgba(59, 130, 246, 0.15) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(59, 130, 246, 0.15) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(59, 130, 246, 0.15) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(59, 130, 246, 0.15) 75%),

                linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%),

                url('https://images.unsplash.com/photo-1604719312566-8912e9227c6a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2574&q=80');

            background-size: 60px 60px, 60px 60px, 60px 60px, 60px 60px, cover, cover;
            background-position: 0 0, 0 30px, 30px -30px, -30px 0px, center, center;
            background-repeat: repeat, repeat, repeat, repeat, no-repeat, no-repeat;
            animation: fabricPattern 25s linear infinite;
        } */


        .fabric-bg {
    position: relative;
    height: 100vh; /* Full viewport height */
    overflow: hidden;
}

/* Background pattern with your local image */
.fabric-pattern {
    background-image:
        /* Your local image */
        url("{{ asset('images/profile.jpg') }}"),
        /* Pattern overlays */
        linear-gradient(45deg, rgba(59, 130, 246, 0.15) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(59, 130, 246, 0.15) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, rgba(59, 130, 246, 0.15) 75%),
        linear-gradient(-45deg, transparent 75%, rgba(59, 130, 246, 0.15) 75%),
        /* Color overlay */
        linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);

    background-size:
        cover, /* Image size */
        60px 60px, 60px 60px, 60px 60px, 60px 60px, /* Pattern sizes */
        cover; /* Gradient size */

    background-position:
        center, /* Image position */
        0 0, 0 30px, 30px -30px, -30px 0px, /* Pattern positions */
        center; /* Gradient position */

    background-repeat:
        no-repeat, /* Image repeat */
        repeat, repeat, repeat, repeat, /* Pattern repeats */
        no-repeat; /* Gradient repeat */

    background-blend-mode: overlay;
    animation: fabricPattern 25s linear infinite;
    opacity: 0.9; /* Adjust transparency */
}

/* Texture overlay */
.fabric-texture {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 2px,
            rgba(255, 255, 255, 0.03) 2px,
            rgba(255, 255, 255, 0.03) 4px
        ),
        repeating-linear-gradient(
            0deg,
            transparent,
            transparent 2px,
            rgba(255, 255, 255, 0.03) 2px,
            rgba(255, 255, 255, 0.03) 4px
        );
    z-index: 1;
}

/* Content styling */
.overlay-content {
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    z-index: 2;
}



        @keyframes fabricPattern {
            0% { background-position: 0 0, 0 30px, 30px -30px, -30px 0px, center, center; }
            100% { background-position: 60px 60px, 60px 90px, 90px 30px, 30px 60px, center, center; }
        }

        /* Enhanced form styling */
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.9);
        }

        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 1);
        }

        .login-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        /* Fabric icons with enhanced visibility */
        .fabric-icon {
            position: absolute;
            opacity: 0.2;
            font-size: 4rem;
            color: white;
            animation: float 6s ease-in-out infinite;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .fabric-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .fabric-icon:nth-child(2) { top: 20%; right: 15%; animation-delay: 2s; }
        .fabric-icon:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 4s; }
        .fabric-icon:nth-child(4) { bottom: 10%; right: 10%; animation-delay: 1s; }

        /* Additional fabric texture overlay */
        .fabric-texture {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 2px,
                    rgba(255, 255, 255, 0.03) 2px,
                    rgba(255, 255, 255, 0.03) 4px
                ),
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(255, 255, 255, 0.03) 2px,
                    rgba(255, 255, 255, 0.03) 4px
                );
            pointer-events: none;
        }

        /* Improved text readability */
        .overlay-content {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 2rem;
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Side (Form) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-6 md:px-12 bg-blue-200">
        <div class="max-w-md w-full mx-auto">
            <div class="form-container">
                <!-- Logo/Brand -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="logo">
                    </div>
                    <h1 class="text-3xl font-bold text-blue-700 mb-2">Kelani Fabrics</h1>
                    <p class="text-gray-500">Admin Portal Access</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username or Email</label>
                        <input id="username" type="text" name="username" required autofocus
                            class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none"
                            placeholder="Enter your username or email"
                            value="{{ old('username') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none pr-12"
                                placeholder="Enter your password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                                <svg class="h-5 w-5 text-gray-400" id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>
                        {{-- <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">Forgot password?</a>
                        </div> --}}
                    </div>

                    <button type="submit" class="login-btn w-full py-3 px-4 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign in to Dashboard
                        </span>
                    </button>
                </form>

                {{-- <p class="text-center text-sm text-gray-600 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">Register</a>
                </p> --}}
                {{-- <p class="text-center text-sm text-gray-600 mt-2">
                    Need help accessing your account?
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition">Contact Support</a>
                </p> --}}
            </div>
        </div>
    </div>

    <!-- Right Side (Fabric Background with Image) -->
    <div class="hidden md:block md:w-1/2 relative" id="fabricBackground">
         <div class="absolute inset-0 bg-cover bg-center z-0">
        <img src="{{ asset('images/profile2.jpg') }}" alt="background"
             class="w-full h-full object-cover">
        </div>
        {{-- <img src="{{ asset('images/profile.jpg') }}" alt="profile"> --}}
        <div class="fabric-texture"></div>


        <!-- Overlay content -->
        <div class="absolute inset-0 flex items-center justify-center p-8">
            <div class="text-center text-white overlay-content">
                <h2 class="text-4xl font-bold mb-4">Welcome to</h2>
                <h1 class="text-5xl font-bold mb-6">Kelani Fabrics</h1>
                <p class="text-xl opacity-90 max-w-md">
                    Your premier destination for quality fabrics and textile solutions.
                    Manage your business with our comprehensive admin portal.
                </p>
                <div class="mt-8 space-x-4">
                    <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm backdrop-blur-sm">
                        Quality Fabrics
                    </span>
                    <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm backdrop-blur-sm">
                        Expert Service
                    </span>
                    <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm backdrop-blur-sm">
                        Trusted Partner
                    </span>
                </div>

                <!-- Quality showcase -->
                <div class="mt-8 text-sm opacity-75">
                    <p>✨ Premium fabric management system</p>
                </div>
            </div>
        </div>
    </div>

  <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>
</html>
