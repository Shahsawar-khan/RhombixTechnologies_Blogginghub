@extends('layouts.admin')
@section('title', 'Comments')
@section('page-title', 'Comments Management')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="font-bold">All Comments</h2>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">User</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Comment</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Post</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-medium">
                        {{ $comment->name }}
                        <div class="text-xs text-slate-400">{{ $comment->email }}</div>
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ Str::limit($comment->body, 60) }}</td>
                    <td class="px-6 py-3 text-sm">{{ Str::limit($comment->post->title ?? 'N/A', 30) }}</td>
                    <td class="px-6 py-3">
                        @if($comment->approved)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Approved</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-bold uppercase">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm flex gap-2">
                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:underline font-medium">
                                {{ $comment->approved ? 'Unapprove' : 'Approve' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                              onsubmit="return confirm('Delete this comment?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">No comments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $comments->links() }}</div>
</div>
@endsection