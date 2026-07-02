<?php
foreach(glob('app/Http/Controllers/*.php') as $f) {
    $content = file_get_contents($f);
    $content = str_replace('\app\Models', '\App\Models', $content);
    file_put_contents($f, $content);
}
echo "Fixed namespaces.\n";
