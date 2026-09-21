@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories Management')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="font-bold">All Categories</h2>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            + New Category
        </a>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">ID</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Slug</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Posts</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm">{{ $category->id }}</td>
                    <td class="px-6 py-3 text-sm font-medium">{{ $category->name }}</td>
                    <td class="px-6 py-3 text-sm text-slate-500">{{ $category->slug }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-bold">
                            {{ $category->posts_count }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-indigo-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $categories->links() }}</div>
</div>
@endsection