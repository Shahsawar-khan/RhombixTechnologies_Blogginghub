<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'users' => User::count(),
            'comments' => Comment::count(),
            'categories' => Category::count(),
        ];

        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentComments = Comment::with('post')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments'));
    }
}