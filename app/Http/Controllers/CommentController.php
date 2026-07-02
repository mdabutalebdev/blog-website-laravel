<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;



use App\Models\Comment;

class CommentController {
    public function index(Request $request) {
        $post_id = $request->input('post_id');
        if (!$post_id) {
            return response()->json(['error' => 'Post ID required'], 400);
        }

        $all_comments = Comment::getByPostId($post_id);
        $comments = [];
        $replies = [];

        foreach ($all_comments as $c) {
            if (!empty($c['parent_id'])) {
                $replies[$c['parent_id']][] = $c;
            } else {
                $comments[] = $c;
            }
        }
        
        // Output raw HTML components for comments to simplify frontend rendering
        ob_start();
        if (empty($comments)) {
            echo '<div class="text-sm text-gray-500">No comments yet.</div>';
        } else {
            foreach ($comments as $comment) {
                $comment_replies = $replies[$comment['id']] ?? [];
                echo view('components.CommentItem', ['comment' => $comment, 'replies' => $comment_replies])->render();
            }
        }
        $html = ob_get_clean();

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function store(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $post_id = $body['post_id'] ?? null;
        $content = $body['content'] ?? null;
        $parent_id = $body['parent_id'] ?? null;

        if (!$post_id || !$content) {
            return response()->json(['error' => 'Missing data'], 400);
        }

        $id = Comment::create($post_id, Auth::id(), htmlspecialchars($content), $parent_id);
        return response()->json(['success' => true]);
    }

    public function toggleLike(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $comment_id = $body['comment_id'] ?? null;

        if (!$comment_id) {
            return response()->json(['error' => 'Comment ID required'], 400);
        }

        $result = Comment::toggleLike($comment_id, Auth::id());
        return response()->json(array_merge(['success' => true], $result));
    }
}
