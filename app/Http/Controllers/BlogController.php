<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;




use App\Models\Post;

class BlogController {
    public function index(Request $request) {
        $posts = Post::all();
        return view('blog/index', ['posts' => $posts]);
    }
}
