<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; }
        .input-field {
            width: 100%; padding: 14px 16px 14px 44px; border: 1.5px solid #E2E8F0;
            border-radius: 12px; font-size: 15px; outline: none;
            transition: all 0.2s; background: #fff;
        }
        .input-field:focus { border-color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.1); }
        .input-icon {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #94A3B8; font-size: 18px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home.page') }}" class="inline-flex items-center gap-2 mb-3">
            <span class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white px-3 py-2 rounded-xl font-extrabold text-xl shadow-lg shadow-indigo-500/30">B</span>
            <span class="text-2xl font-extrabold text-slate-800">BlogHub</span>
        </a>
        <p class="text-slate-500 text-sm mt-2">Read, write, and share your stories</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

        {{-- Tabs --}}
        <div class="flex bg-slate-100 rounded-xl p-1 mb-6">
            <button id="tab-login" onclick="switchTab('login')"
                    class="flex-1 py-2.5 rounded-lg font-semibold text-sm transition-all bg-white shadow text-indigo-600">
                Login
            </button>
            <button id="tab-register" onclick="switchTab('register')"
                    class="flex-1 py-2.5 rounded-lg font-semibold text-sm transition-all text-slate-500">
                Register
            </button>
        </div>

        {{-- LOGIN FORM --}}
        <div id="form-login">
            <h1 class="text-2xl font-extrabold mb-1 text-slate-800">Welcome back</h1>
            <p class="text-slate-500 text-sm mb-6">Login to your BlogHub account</p>

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="relative">
                    <span class="input-icon">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-field" placeholder="Email address" required autofocus>
                </div>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                           class="input-field" placeholder="Password" required>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded">
                        <span class="text-slate-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-indigo-600 font-medium hover:underline text-xs">
                            Forgot?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 transition-all">
                    Login
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-slate-500">
                New here?
                <button onclick="switchTab('register')" class="text-indigo-600 font-semibold hover:underline">Create account</button>
            </p>
        </div>

        {{-- REGISTER FORM --}}
        <div id="form-register" class="hidden">
            <h1 class="text-2xl font-extrabold mb-1 text-slate-800">Create account</h1>
            <p class="text-slate-500 text-sm mb-6">Join the BlogHub community</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="relative">
                    <span class="input-icon">👤</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="input-field" placeholder="Full name" required>
                </div>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="relative">
                    <span class="input-icon">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-field" placeholder="Email address" required>
                </div>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                           class="input-field" placeholder="Password (min 8 chars)" required>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password_confirmation"
                           class="input-field" placeholder="Confirm password" required>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 transition-all">
                    Create Account
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-slate-500">
                Already have an account?
                <button onclick="switchTab('login')" class="text-indigo-600 font-semibold hover:underline">Login</button>
            </p>
        </div>

    </div>

    <p class="text-center text-xs text-slate-400 mt-6">
        © 2025 BlogHub. All rights reserved.
    </p>

</div>

<script>
    function switchTab(tab) {
        const loginForm = document.getElementById('form-login');
        const registerForm = document.getElementById('form-register');
        const loginTab = document.getElementById('tab-login');
        const registerTab = document.getElementById('tab-register');

        if (tab === 'login') {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('bg-white', 'shadow', 'text-indigo-600');
            loginTab.classList.remove('text-slate-500');
            registerTab.classList.remove('bg-white', 'shadow', 'text-indigo-600');
            registerTab.classList.add('text-slate-500');
        } else {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            registerTab.classList.add('bg-white', 'shadow', 'text-indigo-600');
            registerTab.classList.remove('text-slate-500');
            loginTab.classList.remove('bg-white', 'shadow', 'text-indigo-600');
            loginTab.classList.add('text-slate-500');
        }
    }

    @if($errors->has('name') || $errors->has('password_confirmation'))
        switchTab('register');
    @endif
</script>

</body>
</html>