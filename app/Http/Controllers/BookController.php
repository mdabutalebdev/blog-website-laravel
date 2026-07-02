<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;




use App\Models\Book;

class BookController {
    public function index(Request $request) {
        $books = Book::all();
        return view('books/index', ['books' => $books]);
    }

    public function upload(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('books/upload');
    }

    public function store(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $title = $request->input('title');
        $total_pages = (int) $request->input('total_pages');
        
        if (empty($title) || $total_pages <= 0) {
            return view('books/upload', ['error' => 'Invalid title or pages']);
        }

        if (!$request->hasFile('pdf_file') || !$request->file('pdf_file')->isValid()) {
            return view('books/upload', ['error' => 'Error uploading file']);
        }

        $file = $request->file('pdf_file');
        
        if ($file->getMimeType() !== 'application/pdf') {
            return view('books/upload', ['error' => 'Only PDF files are allowed']);
        }

        $uploadDir = storage_path('books/');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid('book_') . '.pdf';

        // Handle Cover Image
        $cover_image_path = null;
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $coverDir = public_path('uploads/covers/');
            if (!is_dir($coverDir)) {
                mkdir($coverDir, 0755, true);
            }
            $cover_filename = uniqid('book_cover_') . '_' . basename($request->file('cover_image')->getClientOriginalName());
            $cover_filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $cover_filename);
            
            $request->file('cover_image')->move($coverDir, $cover_filename);
            $cover_image_path = '/uploads/covers/' . $cover_filename;
        }

        try {
            $file->move($uploadDir, $filename);
            // Save to DB
            Book::create(Auth::id(), $title, $total_pages, $filename, $cover_image_path);
            return redirect('/books');
        } catch (\Exception $e) {
            return view('books/upload', ['error' => 'Failed to save file: ' . $e->getMessage()]);
        }
    }

    public function serve(Request $request) {
        $id = $request->input('id'); // we'll use a query param or route param. For now query param ?id=1
        
        if (!$id) {
            $response->setStatusCode(404);
            echo "Not found"; return;
        }

        $book = Book::findById($id);
        if (!$book) {
            $response->setStatusCode(404);
            echo "Not found"; return;
        }

        $path = storage_path('books/') . $book['pdf_path'];
        if (file_exists($path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($book['pdf_path']) . '"');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        } else {
            $response->setStatusCode(404);
            echo "File missing"; return;
        }
    }
}
