<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use \Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminPostController extends Controller
{
    
    public function index()
    {

        return Post::orderBy( 'created_at', 'desc' )->take(10)->get();
        
    }

    public function show()
    {

        return Post::where( 'post_slug', request( 'slug' ) )->get();
        
    }

    public function update( $id, Request $request )
    {        

        $post = Post::find( $id );

        $attributes = request()->validate([

            'post_title' => ['required', 'max:255', Rule::unique( 'posts', 'post_title' )->ignore( $post->id )],
            'post_excerpt'  => ['required'],
            'post_content'  => ['required'],
            'post_slug' => ['required', Rule::unique( 'posts', 'post_slug' )->ignore($post->id)],

        ]);

        $post->update( $attributes );

        return $post;

    }

    public function store()
    {

        $attributes = request()->validate([

            'post_title'    => ['required', 'max:255', Rule::unique( 'posts', 'post_title' )],
            'post_excerpt'  => ['required'],
            'post_content'  => ['required'],
            'post_slug'     => ['required', Rule::unique( 'posts', 'post_slug' )],

        ]);

        $attributes['post_author'] = auth()->id();
        $attributes['post_status'] = 'publish';
        $attributes['post_type']   = 'news';

        $post = Post::create( $attributes );

        return $post;

    }

    public function destroy( $id )
    {

        $post = Post::find( $id );

        $post->delete();

        return 'success';

    }

}
