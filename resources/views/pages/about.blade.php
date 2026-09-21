<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

{{-- NAVBAR --}}
<nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('home.page') }}" class="flex items-center gap-2">
            <span class="bg-indigo-600 text-white w-9 h-9 rounded-lg flex items-center justify-center font-extrabold text-lg">B</span>
            <span class="text-xl font-extrabold text-slate-800">BlogHub</span>
        </a>
        <ul class="hidden md:flex gap-6 list-none">
            <li><a href="{{ route('home.page') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Home</a></li>
            <li><a href="{{ route('about') }}" class="text-indigo-600 font-semibold text-sm">About</a></li>
            <li><a href="{{ route('contact') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Contact</a></li>
        </ul>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 px-3 py-2">Login</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white py-16 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">About BlogHub</h1>
        <p class="text-white/90 text-lg">A place where writers and readers come together to share ideas, stories, and knowledge.</p>
    </div>
</section>

{{-- CONTENT --}}
<div class="max-w-4xl mx-auto px-4 py-12">

    {{-- Our Story --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8 mb-8">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
            <span class="text-3xl">📖</span> Our Story
        </h2>
        <p class="text-slate-600 leading-relaxed mb-4">
            BlogHub was created with a simple mission: to give everyone a platform to share their thoughts, ideas, and stories with the world. We believe that knowledge should be accessible to everyone, and that every voice deserves to be heard.
        </p>
        <p class="text-slate-600 leading-relaxed">
            Whether you're a developer sharing coding tips, a traveler documenting your journeys, or a foodie writing about your favorite recipes — BlogHub is the place for you.
        </p>
    </div>

    {{-- What We Offer --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8 mb-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <span class="text-3xl">✨</span> What We Offer
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl flex-shrink-0">📝</div>
                <div>
                    <h3 class="font-bold mb-1">Write & Publish</h3>
                    <p class="text-sm text-slate-600">Share your stories with a rich text editor and beautiful formatting.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl flex-shrink-0">🔍</div>
                <div>
                    <h3 class="font-bold mb-1">Discover Content</h3>
                    <p class="text-sm text-slate-600">Find posts by category, tag, or search across all topics.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl flex-shrink-0">💬</div>
                <div>
                    <h3 class="font-bold mb-1">Engage & Discuss</h3>
                    <p class="text-sm text-slate-600">Comment on posts and join the conversation with other readers.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl flex-shrink-0">🏷️</div>
                <div>
                    <h3 class="font-bold mb-1">Organize & Filter</h3>
                    <p class="text-sm text-slate-600">Browse posts by categories and tags for easy discovery.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">100+</div>
            <div class="text-sm text-slate-500 mt-1">Posts</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">50+</div>
            <div class="text-sm text-slate-500 mt-1">Authors</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center">
            <div class="text-3xl font-extrabold text-indigo-600">1000+</div>
            <div class="text-sm text-slate-500 mt-1">Readers</div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-10 text-white text-center">
        <h2 class="text-2xl font-bold mb-3">Ready to Share Your Story?</h2>
        <p class="text-white/90 mb-6">Join our community of writers and readers today.</p>
        @guest
            <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-xl font-bold hover:bg-slate-100 transition">
                Get Started
            </a>
        @endguest
        @auth
            <a href="{{ route('home.page') }}" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-xl font-bold hover:bg-slate-100 transition">
                Explore Posts
            </a>
        @endauth
    </div>

</div>

{{-- FOOTER --}}
<footer class="bg-slate-800 text-slate-400 py-10 mt-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <div class="flex items-center justify-center gap-2 mb-4">
            <span class="bg-indigo-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-extrabold">B</span>
            <span class="text-lg font-bold text-white">BlogHub</span>
        </div>
        <div class="flex justify-center gap-6 text-sm mb-4">
            <a href="{{ route('home.page') }}" class="hover:text-white">Home</a>
            <a href="{{ route('about') }}" class="hover:text-white">About</a>
            <a href="{{ route('contact') }}" class="hover:text-white">Contact</a>
        </div>
        <p class="text-xs">© 2025 BlogHub. All rights reserved.</p>
    </div>
</footer>

</body>
</html>