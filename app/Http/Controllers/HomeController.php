<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;





class HomeController {
    public function index(Request $request) {
        $q = $request->input('q');
        
        $categories = \App\Models\Post::getCategoriesWithCounts();
        $totalPosts = count(\App\Models\Post::all()); // Total across all categories
        
        // Check for slug or query parameter
        $categorySlug = $request->route('slug');
        $category = $request->input('category'); // Fallback for old query param

        if ($categorySlug) {
            // Find the original category name matching the slug
            $found = false;
            foreach ($categories as $cat) {
                if (slugify($cat['category']) === $categorySlug) {
                    $category = $cat['category'];
                    $found = true;
                    break;
                }
            }
            // If category has 0 posts, it won't be in $categories list. 
            // We should still filter by it so the banner shows and 0 posts are returned.
            if (!$found) {
                $category = ucwords(str_replace('-', ' ', $categorySlug));
            }
        }

        $page = $request->input('page', 1);
        $perPage = 12;
        
        $result = \App\Models\Post::searchAndFilterPaginated($q, $category, $page, $perPage);
        
        $posts = new \Illuminate\Pagination\LengthAwarePaginator(
            $result['data'],
            $result['total'],
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        $banners = \App\Models\Banner::all();

        return view('home/index', [
            'posts' => $posts,
            'categories' => $categories,
            'totalPosts' => $totalPosts,
            'currentCategory' => $category,
            'currentSearch' => $q,
            'banners' => $banners
        ]);
    }
}
