<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    
    public function index()
    {

        return Post::orderBy('created_at', 'desc')->take(10)->get();
        
    }

    public function show()
    {

        return Post::where( 'post_slug', request( 'slug' ) )->get();
        
    }
}
