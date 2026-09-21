<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-field {
            width: 100%; padding: 12px 16px; border: 1.5px solid #E2E8F0;
            border-radius: 10px; font-size: 15px; outline: none;
            transition: 0.2s;
        }
        .input-field:focus { border-color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.1); }
    </style>
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
            <li><a href="{{ route('about') }}" class="text-slate-600 hover:text-indigo-600 font-medium text-sm">About</a></li>
            <li><a href="{{ route('contact') }}" class="text-indigo-600 font-semibold text-sm">Contact</a></li>
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
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Get in Touch</h1>
        <p class="text-white/90 text-lg">Have a question, suggestion, or just want to say hi? We'd love to hear from you.</p>
    </div>
</section>

{{-- CONTENT --}}
<div class="max-w-6xl mx-auto px-4 py-12">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-8 max-w-2xl mx-auto">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-8">

        {{-- Contact Info --}}
        <div class="md:col-span-1 space-y-4">

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl mb-4">📧</div>
                <h3 class="font-bold mb-1">Email Us</h3>
                <p class="text-sm text-slate-600 mb-2">We reply within 24 hours</p>
                <a href="mailto:hello@bloghub.com" class="text-indigo-600 text-sm font-medium hover:underline">
                    hello@bloghub.com
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl mb-4">📍</div>
                <h3 class="font-bold mb-1">Visit Us</h3>
                <p class="text-sm text-slate-600">
                    123 Blog Street<br>
                    Karachi, Pakistan
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl mb-4">📱</div>
                <h3 class="font-bold mb-1">Call Us</h3>
                <p class="text-sm text-slate-600 mb-2">Mon-Fri, 9am - 5pm</p>
                <a href="tel:+923001234567" class="text-indigo-600 text-sm font-medium hover:underline">
                    +92 300 1234567
                </a>
            </div>

        </div>

        {{-- Contact Form --}}
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 p-8">
                <h2 class="text-2xl font-bold mb-2">Send us a Message</h2>
                <p class="text-slate-500 mb-6">Fill out the form below and we'll get back to you as soon as possible.</p>

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Your Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                   class="input-field" placeholder="John Doe" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                   class="input-field" placeholder="you@example.com" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="input-field" placeholder="How can we help?" required>
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Message</label>
                        <textarea name="message" rows="6"
                                  class="input-field" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-500/30 transition">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

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