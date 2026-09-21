<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-input { width: 100%; padding: 12px 16px; border: 2px solid #E2E8F0; border-radius: 10px; font-size: 15px; outline: none; transition: 0.2s; }
        .form-input:focus { border-color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.1); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-2xl mx-auto px-6 py-10">

    <a href="{{ route('profile.show') }}" class="text-indigo-600 font-medium text-sm">← Back to Profile</a>

    <h1 class="text-3xl font-extrabold mt-4 mb-8">Edit Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-lg mb-5">Basic Information</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input" required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold">
                Save Changes
            </button>
        </form>
    </div>

    {{-- Password --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-lg mb-5">Change Password</h2>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PATCH')

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Current Password</label>
                <input type="password" name="current_password" class="form-input" required>
                @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">New Password</label>
                <input type="password" name="password" class="form-input" required>
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold">
                Update Password
            </button>
        </form>
    </div>

</div>

</body>
</html>