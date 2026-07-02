<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $pendingPosts = Post::getPendingPosts();
        $banners = \App\Models\Banner::all();
        return view('admin.dashboard', ['pendingPosts' => $pendingPosts, 'banners' => $banners]);
    }

    public function approvePost(Request $request, $id)
    {
        Post::approve($id);
        return redirect('/admin')->with('success', 'Post approved successfully.');
    }

    public function deletePost(Request $request, $id)
    {
        Post::delete($id);
        return redirect('/admin')->with('success', 'Post rejected and deleted.');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string|max:1000',
            'banner_media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,webm,mov|max:20480',
        ]);

        if ($request->hasFile('banner_media')) {
            $file = $request->file('banner_media');
            $extension = $file->getClientOriginalExtension();
            $filename = 'banner_' . time() . '.' . $extension;
            $file->move(public_path('uploads/banner'), $filename);

            $path = '/uploads/banner/' . $filename;
            $type = in_array(strtolower($extension), ['mp4', 'webm', 'mov']) ? 'video' : 'image';
            
            \App\Models\Banner::create([
                'heading' => $request->input('heading'),
                'paragraph' => $request->input('paragraph'),
                'media_path' => $path,
                'media_type' => $type,
            ]);
        }

        return redirect('/admin')->with('success', 'Banner added successfully.');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = \App\Models\Banner::find($id);
        if (!$banner) {
            return redirect('/admin')->with('error', 'Banner not found.');
        }

        $request->validate([
            'heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string|max:1000',
            'banner_media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,mov|max:20480',
        ]);

        $banner->heading = $request->input('heading');
        $banner->paragraph = $request->input('paragraph');

        if ($request->hasFile('banner_media')) {
            // Delete old file
            $oldPath = public_path($banner->media_path);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }

            $file = $request->file('banner_media');
            $extension = $file->getClientOriginalExtension();
            $filename = 'banner_' . time() . '.' . $extension;
            $file->move(public_path('uploads/banner'), $filename);

            $banner->media_path = '/uploads/banner/' . $filename;
            $banner->media_type = in_array(strtolower($extension), ['mp4', 'webm', 'mov']) ? 'video' : 'image';
        }

        $banner->save();

        return redirect('/admin')->with('success', 'Banner updated successfully.');
    }

    public function deleteBanner(Request $request, $id)
    {
        $banner = \App\Models\Banner::find($id);
        if ($banner) {
            // Delete file if exists
            $filePath = public_path($banner->media_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $banner->delete();
        }
        return redirect('/admin')->with('success', 'Banner deleted successfully.');
    }

    public function updateSettings(Request $request)
    {
        $settings = $request->except(['_token']);
        
        foreach ($settings as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        return redirect('/admin')->with('success', 'Settings updated successfully.');
    }
}
