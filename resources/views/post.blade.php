<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} — BlogHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-3xl mx-auto px-6 py-8">

    <a href="{{ route('home.page') }}" class="text-indigo-600 font-medium text-sm">← Back to Home</a>

    <article class="mt-6">
        @if($post->categories->first())
            <span class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-xs font-bold uppercase mb-4">
                {{ $post->categories->first()->name }}
            </span>
        @endif

        <h1 class="text-4xl font-extrabold mb-5 leading-tight">{{ $post->title }}</h1>

        <div class="flex items-center gap-4 text-sm text-slate-500 pb-6 border-b border-slate-200 mb-6">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <span class="font-semibold text-slate-700">{{ $post->user->name }}</span>
            </div>
            <span>📅 {{ $post->published_at?->format('M d, Y') }}</span>
        </div>

        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-full rounded-xl mb-8">
        @endif

        <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
            {!! $post->content !!}
        </div>

        @if($post->tags->count() > 0)
            <div class="mt-8 flex gap-2 flex-wrap">
                @foreach($post->tags as $tag)
                    <span class="bg-white border border-slate-200 px-3 py-1 rounded-full text-xs text-slate-600">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </article>

    {{-- Comments --}}
    <section class="mt-12 pt-8 border-t border-slate-200">
        <h2 class="text-2xl font-bold mb-6">💬 Comments ({{ $post->approvedComments->count() }})</h2>

        @forelse($post->approvedComments as $comment)
            <div class="bg-white rounded-xl border border-slate-200 p-5 mb-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-red-500 text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold">{{ $comment->name }}</div>
                        <div class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <p class="text-slate-600">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-slate-400 text-center py-6">No comments yet. Be the first!</p>
        @endforelse

        {{-- Comment Form --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 mt-6">
            <h3 class="font-bold text-lg mb-4">Leave a Comment</h3>
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                @auth
                    <input type="text" name="name" value="{{ auth()->user()->name }}" readonly
                           class="w-full px-4 py-3 border border-slate-200 rounded-lg mb-3 bg-slate-50">
                    <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                           class="w-full px-4 py-3 border border-slate-200 rounded-lg mb-3 bg-slate-50">
                @else
                    <input type="text" name="name" placeholder="Your Name" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-lg mb-3">
                    <input type="email" name="email" placeholder="Your Email" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-lg mb-3">
                @endauth
                <textarea name="body" placeholder="Write your comment..." required
                          class="w-full px-4 py-3 border border-slate-200 rounded-lg mb-4 min-h-[100px]"></textarea>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Post Comment
                </button>
            </form>
        </div>
    </section>

</div>

<footer class="bg-slate-800 text-slate-400 text-center py-8 mt-16 text-sm">
    © 2025 BlogHub. All rights reserved.
</footer>

</body>
</html>