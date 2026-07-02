<?php
$viewsDir = 'F:/blog site root/blog-site-laravel/resources/views';

function fixBlades($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            // Ignore layouts and components directories
            if ($file !== 'layouts' && $file !== 'components') {
                fixBlades($path);
            }
        } else {
            if (strpos($file, '.blade.php') !== false) {
                $content = file_get_contents($path);
                if (strpos($content, '@extends') === false) {
                    $newContent = "@extends('layouts.MainLayout')\n@section('content')\n" . $content . "\n@endsection\n";
                    file_put_contents($path, $newContent);
                }
            }
        }
    }
}

fixBlades($viewsDir);

// Fix MainLayout
$layoutPath = $viewsDir . '/layouts/MainLayout.blade.php';
if (file_exists($layoutPath)) {
    $layout = file_get_contents($layoutPath);
    // Replace {{content}} with @yield('content')
    // Note: since it was {{content}}, my migrate script might have turned it into {{ $content }} or left it alone.
    // In old layout, it was literally {{content}}.
    // Let's replace both just in case.
    $layout = str_replace('{{content}}', "@yield('content')", $layout);
    $layout = str_replace('{{ content }}', "@yield('content')", $layout);
    file_put_contents($layoutPath, $layout);
}

echo "Fixed Blade layouts.\n";
