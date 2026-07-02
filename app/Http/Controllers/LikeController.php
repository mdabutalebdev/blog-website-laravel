<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;



use App\Models\Like;

class LikeController {
    public function toggle(Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $post_id = $body['post_id'] ?? null;

        if (!$post_id) {
            return response()->json(['error' => 'Post ID required'], 400);
        }

        $result = Like::toggle($post_id, Auth::id());
        
        return response()->json(['success' => true, 'status' => $result['status']]);
    }
}
