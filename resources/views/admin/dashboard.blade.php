@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STATS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">📝</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['posts'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Total Posts</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-2xl">👥</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['users'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Users</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center text-2xl">💬</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['comments'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Comments</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">📂</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['categories'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Categories</p>
        </div>
    </div>

</div>

{{-- RECENT POSTS --}}
<div class="bg-white rounded-xl border border-slate-200 mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="font-bold text-slate-700">Recent Posts</h2>
        <a href="{{ route('admin.posts.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            + New Post
        </a>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Title</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Author</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPosts as $post)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-medium">{{ $post->title }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $post->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">
                        @if($post->status === 'published')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Published</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-bold uppercase">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-500">{{ $post->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">No posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- RECENT COMMENTS --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="font-bold text-slate-700">Recent Comments</h2>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">User</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Comment</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentComments as $comment)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-medium">{{ $comment->name }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ Str::limit($comment->body, 50) }}</td>
                    <td class="px-6 py-3">
                        @if($comment->approved)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Approved</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-bold uppercase">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-6 py-8 text-center text-slate-400">No comments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection