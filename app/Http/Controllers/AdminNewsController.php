<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use \Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminNewsController extends Controller
{
    
    public function index()
    {

        return News::orderBy( 'created_at', 'desc' )->take(10)->get();
        
    }

    public function show()
    {

        $post = News::where( 'slug', request( 'slug' ) )->get();

        $post[0]->content = htmlspecialchars_decode( $post[0]->content );

        return $post;
        
    }

    public function update( $id, Request $request )
    {        

        $post = News::find( $id );

        $attributes = request()->validate([

            'title' => ['required', 'max:255', Rule::unique( 'news', 'title' )->ignore( $post->id )],
            'excerpt'  => ['required'],
            'content'  => ['required'],
            'slug' => ['required', Rule::unique( 'news', 'slug' )->ignore($post->id)],

        ]);

        $attributes['content'] = mx_sanitize_content( $attributes['content'] );

        $post->update( $attributes );

        return $post;

    }

    public function store()
    {

        $attributes = request()->validate([

            'title'    => ['required', 'max:255', Rule::unique( 'news', 'title' )],
            'excerpt'  => ['required'],
            'content'  => ['required'],
            'slug'     => ['required', Rule::unique( 'news', 'slug' )],

        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['status'] = 'publish';

        $post = News::create( $attributes );

        return $post;

    }

    public function destroy( $id )
    {

        $post = News::find( $id );

        $post->delete();

        return 'success';

    }

}
