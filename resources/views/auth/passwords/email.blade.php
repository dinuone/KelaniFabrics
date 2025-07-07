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
                    <p class="text-gray-500">Reset Password</p>
                </div>

                <!-- Status Message -->
                @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
                @endif

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

                <!-- Password Reset Request Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-field w-full px-4 py-3 border rounded-lg focus:outline-none"
                            placeholder="Enter your email address">
                    </div>

                    <button type="submit" class="submit-btn w-full py-3 px-4 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Password Reset Link
                        </span>
                    </button>
                </form>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Remember your password?
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
                <h2 class="text-4xl font-bold mb-4">Password Recovery</h2>
                <h1 class="text-5xl font-bold mb-6">Kelani Fabrics</h1>
                <p class="text-xl opacity-90 max-w-md">
                    Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
