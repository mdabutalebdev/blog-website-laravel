<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;




use App\Models\Post;

class PostController {
    public function create(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('blog/create');
    }

    public function store(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $title = $request->input('title');
        $content = $request->input('content'); 
        $category = $request->input('category');
        
        if (empty($title) || empty($content)) {
            return response()->json(['error' => 'Title and content are required'], 400);
        }

        // Handle cover image upload
        $cover_image_path = null;
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('uploads/covers/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = uniqid('cover_') . '_' . basename($_FILES['cover_image']['name']);
            // Very basic sanitize
            $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
            
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename)) {
                $cover_image_path = '/uploads/covers/' . $filename;
            }
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))) . '-' . uniqid();
        
        try {
            $postId = Post::create(Auth::id(), $title, $slug, $content, $cover_image_path, $category);
            return response()->json(['success' => true, 'redirect' => '/']);
        } catch (\PDOException $e) {
            // Check if it's a packet size error
            if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                return response()->json(['error' => 'The post content is too large. If you inserted large images, please resize them.'], 400);
            }
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function uploadImage(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('uploads/posts/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = uniqid('img_') . '_' . basename($_FILES['image']['name']);
            $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                return response()->json(['success' => true, 'url' => '/uploads/posts/' . $filename]);
            }
        }
        
        return response()->json(['error' => 'Failed to upload image'], 400);
    }

    public function show(Request $request) {
        $slug = $request->route('slug');
        $post = Post::findBySlug($slug);
        
        if (!$post) {
            $response->setStatusCode(404);
            return View::renderError(404);
        }
        
        // 1. Generate TOC and inject IDs into headings
        $toc = [];
        $content = $post['content'];
        
        $headingCount = 0;
        
        // Increase PCRE limits for large posts
        ini_set('pcre.backtrack_limit', '100000000');
        ini_set('pcre.recursion_limit', '100000000');
        
        $contentWithIds = preg_replace_callback('/<(h[23])>(.*?)<\/\1>/is', function($matches) use (&$toc, &$headingCount) {
            $headingCount++;
            $tag = strtolower($matches[1]);
            $text = strip_tags($matches[2]);
            // Generate a safe ID
            $id = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
            if (empty($id)) {
                $id = 'section-' . $headingCount;
            }
            
            $toc[] = [
                'tag' => $tag, // 'h2' or 'h3'
                'text' => $text,
                'id' => $id
            ];
            
            return "<{$matches[1]} id=\"{$id}\">{$matches[2]}</{$matches[1]}>";
        }, $content);
        
        if ($contentWithIds !== null) {
            $post['content'] = $contentWithIds; // Override with injected IDs
        }
        
        // 2. Fetch Related Posts (same category, exclude current)
        $relatedPosts = [];
        if (!empty($post['category'])) {
            $relatedPosts = Post::getRelatedPosts($post['category'], $post['id'], 20);
        }

        return view('blog/show', [
            'post' => $post,
            'toc' => $toc,
            'relatedPosts' => $relatedPosts
        ]);
    }

    public function myBlogs(Request $request) {
        if (!Auth::check()) {
            header("Location: /login");
            exit;
        }
        $posts = Post::getByUser(Auth::id());
        return view('blog/my_blogs', ['posts' => $posts]);
    }

    public function edit(Request $request) {
        if (!Auth::check()) {
            header("Location: /login");
            exit;
        }
        $id = $request->route('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != Auth::id()) {
            $response->setStatusCode(404);
            return View::renderError(404);
        }
        return view('blog/edit', ['post' => $post]);
    }

    public function update(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $id = $request->route('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != Auth::id()) {
            return response()->json(['error' => 'Not found or unauthorized'], 404);
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $category = $request->input('category');

        $cover_image_path = $post['cover_image']; // keep existing
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('uploads/covers/');
            $filename = uniqid('cover_') . '_' . basename($_FILES['cover_image']['name']);
            $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename)) {
                $cover_image_path = '/uploads/covers/' . $filename;
            }
        }

        Post::update($id, $title, $content, $cover_image_path, $category);
        return response()->json(['success' => true, 'redirect' => '/my-blogs']);
    }

    public function delete(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $id = $request->route('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != Auth::id()) {
            return response()->json(['error' => 'Not found or unauthorized'], 404);
        }
        Post::delete($id);
        return response()->json(['success' => true]);
    }
}
