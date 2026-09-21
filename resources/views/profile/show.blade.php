<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

{{-- NAVBAR --}}
@include('partials.navbar')

<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- Profile Header --}}
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-4xl font-extrabold border-4 border-white/40">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-extrabold">{{ $user->name }}</h1>
                <p class="text-white/80 mt-1">{{ $user->email }}</p>
                <p class="text-white/60 text-sm mt-2">Member since {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-5 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">{{ $user->posts()->count() }}</div>
            <div class="text-sm text-slate-500 mt-1">Posts</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">{{ $user->comments()->count() }}</div>
            <div class="text-sm text-slate-500 mt-1">Comments</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">
                {{ $user->hasRole('admin') ? 'Admin' : 'User' }}
            </div>
            <div class="text-sm text-slate-500 mt-1">Role</div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
        <h2 class="font-bold text-lg mb-4">Account Settings</h2>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('profile.edit') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm">
                ✏️ Edit Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-5 py-2.5 rounded-lg font-semibold text-sm">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Recent Posts --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-lg mb-4">My Recent Posts</h2>
        @forelse($posts as $post)
            <div class="border-b border-slate-100 last:border-0 py-3">
                <a href="{{ route('posts.show', $post->slug) }}" class="font-semibold text-slate-800 hover:text-indigo-600">
                    {{ $post->title }}
                </a>
                <div class="text-xs text-slate-400 mt-1">
                    {{ $post->created_at->format('M d, Y') }} · {{ $post->status }}
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-center py-6">No posts yet.</p>
        @endforelse
    </div>

</div>

</body>
</html>