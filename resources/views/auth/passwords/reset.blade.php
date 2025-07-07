<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelani Fabrics - Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Fabric background with single image */
        .fabric-bg {
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

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        /* Fabric texture overlay */
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
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Side (Form) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-6 md:px-12 bg-gray-50">
        <div class="max-w-md w-full mx-auto">
            <div class="form-container">
                <!-- Logo/Brand -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-blue-700 mb-2">Kelani Fabrics</h1>
                    <p class="text-gray-500">Set New Password</p>
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

                <!-- Password Reset Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                            class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none"
                            placeholder="Enter your email address">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none pr-12"
                                placeholder="Enter your new password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password', 'eye-icon')">
                                <svg class="h-5 w-5 text-gray-400" id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none pr-12"
                                placeholder="Confirm your new password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')">
                                <svg class="h-5 w-5 text-gray-400" id="eye-icon-confirm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn w-full py-3 px-4 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Reset Password
                        </span>
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-6">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">Back to Login</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side (Fabric Background with Image) -->
    <div class="hidden md:block md:w-1/2 relative fabric-bg">
        <!-- Fabric texture overlay -->
        <div class="fabric-texture"></div>

        <!-- Overlay content -->
        <div class="absolute inset-0 flex items-center justify-center p-8">
            <div class="text-center text-white bg-black bg-opacity-20 backdrop-blur-sm p-8 rounded-xl">
                <h2 class="text-4xl font-bold mb-4">Create New Password</h2>
                <h1 class="text-5xl font-bold mb-6">Kelani Fabrics</h1>
                <p class="text-xl opacity-90 max-w-md">
                    Set a new secure password for your account to regain access to the Kelani Fabrics management system.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);

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
