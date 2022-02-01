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

        $post = Post::where( 'post_slug', request( 'slug' ) )->get();

        $post[0]->post_content = htmlspecialchars_decode( $post[0]->post_content );

        return $post;
        
    }
}
