<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $posts = MediaPost::with('category')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show(MediaPost $post)
    {
        $post->load([
            'category',
            'contents' => function ($q) {
                $q->orderBy('sort_order');
            }
        ]);

        $previous = MediaPost::where('published_at', '<', $post->published_at)
            ->orderByDesc('published_at')
            ->first();

        $next = MediaPost::where('published_at', '>', $post->published_at)
            ->orderBy('published_at')
            ->first();

        return view('posts.show', compact(
            'post',
            'previous',
            'next'
        ));
    }
}
