<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['heading', 'paragraph', 'media_path', 'media_type'];
}
