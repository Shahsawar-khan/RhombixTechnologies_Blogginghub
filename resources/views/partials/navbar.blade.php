<nav class="sticky top-0 z-50 bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
    <a href="{{ route('home.page') }}" class="text-2xl font-extrabold text-indigo-600 flex items-center gap-2">
        <span class="bg-indigo-600 text-white px-2 py-1 rounded text-base">B</span> BlogHub
    </a>

    <ul class="hidden md:flex gap-8 list-none">
        <li><a href="{{ route('home.page') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Home</a></li>
        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">Categories</a></li>
        <li><a href="#" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">About</a></li>
    </ul>

    <div class="flex items-center gap-3">
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                    Admin
                </a>
            @endif

            {{-- Profile Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button onclick="toggleDropdown()" class="flex items-center gap-2 hover:bg-slate-100 rounded-lg px-2 py-1 transition">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden md:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                    <span class="text-slate-400 text-xs">▼</span>
                </button>

                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <div class="font-semibold text-sm text-slate-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                    </div>

                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                        👤 My Profile
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                        ⚙️ Settings
                    </a>

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                            🛡️ Admin Panel
                        </a>
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
            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold text-sm">Login</a>
        @endauth
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && !e.target.closest('.relative')) {
            dropdown.classList.add('hidden');
        }
    });
</script>