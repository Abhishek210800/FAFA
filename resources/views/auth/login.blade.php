<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast and Fair Arbitration - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fira Sans', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Side: Image -->
        <div class="w-full md:w-1/2 hidden md:block">
            <img src="{{ asset('images/background.png') }}" alt="Handshake" class="w-full h-full object-cover">
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <div class="flex items-center mb-2">
                <img src="{{ asset('images/logoupdated.png') }}" alt="Logo" class="h-16 mr-3">
            </div>

            <h2 class="text-lg font-semibold text-gray-700 mb-4">Log in to your mediation account</h2>

            @if(session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-2">Login</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="Email or phone number"
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Enter password"
                               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror">
                        <button type="button" class="absolute right-3 top-2 text-gray-500">👁️</button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex justify-between items-center mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-500">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-500 text-sm">Forgot password?</a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                    Sign in
                </button>
            </form>

            <p class="text-center text-gray-600 mt-4">
                Don’t have an account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-blue-500">Sign up now</a>
                @endif
            </p>

            <p class="text-center text-gray-500 text-sm mt-6">© 2025 Fast and Fair Arbitration</p>
        </div>
    </div>
</body>
</html>
