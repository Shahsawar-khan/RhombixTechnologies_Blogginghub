<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogHub — Read, Write, Share</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

{{-- ================= NAVBAR ================= --}}
<nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('home.page') }}" class="flex items-center gap-2 flex-shrink-0">
            <span class="bg-indigo-600 text-white w-9 h-9 rounded-lg flex items-center justify-center font-extrabold text-lg">B</span>
            <span class="text-xl font-extrabold text-slate-800">BlogHub</span>
        </a>

        {{-- Nav Links --}}
        <ul class="hidden md:flex gap-6 list-none">
    <li><a href="{{ route('home.page') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Home</a></li>
    <li><a href="{{ route('about') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">About</a></li>
    <li><a href="{{ route('contact') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Contact</a></li>
</ul>

        {{-- Right Actions --}}
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="hidden sm:block text-sm font-medium text-indigo-600 hover:text-indigo-700 px-3 py-2">
                        Admin Panel
                    </a>
                @endif

                {{-- Profile Dropdown --}}
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center gap-2 hover:bg-slate-100 rounded-lg px-2 py-1">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden md:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                    </button>

                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">👤 My Profile</a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">⚙️ Settings</a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">🛡️ Admin Panel</a>
                        @endif
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 px-3 py-2">Login</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                    Sign Up
                </a>
            @endauth
        </div>

    </div>
</nav>

{{-- ================= HERO / SEARCH ================= --}}
<section class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white py-14 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">Discover Stories & Ideas</h1>
        <p class="text-white/90 mb-8">Read, write, and share with the community</p>

        <form method="GET" action="{{ route('home.page') }}" class="flex bg-white rounded-xl p-1.5 shadow-2xl">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="🔍  Search blog posts..."
                   class="flex-1 border-none outline-none px-4 py-3 text-slate-800 rounded-lg">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold">
                Search
            </button>
        </form>
    </div>
</section>

{{-- ================= CATEGORIES FILTER ================= --}}
<div class="max-w-6xl mx-auto px-4 pt-8 flex gap-3 flex-wrap">
    <a href="{{ route('home.page') }}"
       class="px-5 py-2 rounded-full text-sm font-medium border transition
              {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-600' }}">
        All
    </a>
    @foreach($categories as $category)
        <a href="{{ route('home.page', ['category' => $category->slug]) }}"
           class="px-5 py-2 rounded-full text-sm font-medium border transition
                  {{ request('category') === $category->slug ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-600' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>

{{-- ================= POSTS GRID ================= --}}
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Search result info --}}
    @if(request('search'))
        <div class="mb-6 text-slate-600">
            Search results for: <strong class="text-slate-800">"{{ request('search') }}"</strong>
            <a href="{{ route('home.page') }}" class="text-indigo-600 text-sm ml-2 hover:underline">Clear</a>
        </div>
    @endif

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}"
                   class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all block group">

                    {{-- Featured Image --}}
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition-transform">
                    @else
                        <div class="w-full h-44 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-5xl">
                            📝
                        </div>
                    @endif

                    <div class="p-5">

                        {{-- Category Badge --}}
                        @if($post->categories->first())
                            <span class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-xs font-bold uppercase mb-3">
                                {{ $post->categories->first()->name }}
                            </span>
                        @endif

                        {{-- Title --}}
                        <h3 class="font-bold text-lg mb-2 leading-snug line-clamp-2 text-slate-800 group-hover:text-indigo-600">
                            {{ $post->title }}
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                        </p>

                        {{-- Tags --}}
                        @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->tags->take(3) as $tag)
                                    <span class="text-xs text-slate-500">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Meta --}}
                        <div class="flex justify-between items-center text-xs text-slate-400 pt-4 border-t border-slate-100">
                            <span class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </span>
                                <span class="text-slate-600 font-medium">{{ $post->user->name }}</span>
                            </span>
                            <span>📅 {{ $post->published_at?->format('M d') }} · 💬 {{ $post->approvedComments->count() ?? 0 }}</span>
                        </div>

                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">{{ $posts->links() }}</div>

    @else
        <div class="bg-white rounded-xl border border-slate-200 p-16 text-center">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-slate-400 text-lg mb-3">No posts found.</p>
            @if(request('search') || request('category'))
                <a href="{{ route('home.page') }}" class="text-indigo-600 font-semibold">View all posts</a>
            @endif
        </div>
    @endif

</div>

{{-- ================= FOOTER ================= --}}
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

<script>
    function toggleDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }
    document.addEventListener('click', function(e) {
        const d = document.getElementById('profileDropdown');
        if (d && !e.target.closest('.relative')) d.classList.add('hidden');
    });
</script>

</body>
</html>