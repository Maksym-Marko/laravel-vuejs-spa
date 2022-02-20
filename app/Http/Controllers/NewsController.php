<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    
    public function index()
    {

        return News::orderBy('created_at', 'desc')->take(10)->get();
        
    }

    public function show()
    {

        $post = News::where( 'slug', request( 'slug' ) )->get();

        if( isset( $post[0] ) ) {

            $post[0]->content = htmlspecialchars_decode( $post[0]->content );

        }        

        return $post;
        
    }
}
