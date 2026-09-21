@extends('layouts.admin')
@section('title', 'Posts')
@section('page-title', 'Posts Management')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="font-bold">All Posts</h2>
        <a href="{{ route('admin.posts.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            + New Post
        </a>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Image</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Title</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Author</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 class="w-16 h-12 object-cover rounded">
                        @else
                            <div class="w-16 h-12 bg-slate-200 rounded flex items-center justify-center text-xs text-slate-400">
                                No img
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm font-medium">{{ Str::limit($post->title, 40) }}</td>
                    <td class="px-6 py-3 text-sm">{{ $post->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">
                        @if($post->status === 'published')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Published</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-bold uppercase">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm flex gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="text-indigo-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">No posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $posts->links() }}</div>
</div>
@endsection