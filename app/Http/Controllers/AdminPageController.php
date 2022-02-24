<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use \Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminPageController extends Controller
{
    
    public function index()
    {

        return Page::orderBy( 'created_at', 'desc' )->take(10)->get();
        
    }

    public function store()
    {

        $attributes = request()->validate([

            'title'    => ['required', 'max:255', Rule::unique( 'pages', 'title' )],
            'content'  => ['required'],
            'slug'     => ['required', Rule::unique( 'pages', 'slug' )],

        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['status'] = 'publish';

        $page = Page::create( $attributes );

        return $page;

    }

    public function show()
    {

        $page = Page::where( 'slug', request( 'slug' ) )->get();

        $page[0]->content = htmlspecialchars_decode( $page[0]->content );

        return $page;
        
    }

    public function update( $id, Request $request )
    {        

        $page = Page::find( $id );

        $attributes = request()->validate([

            'title' => ['required', 'max:255', Rule::unique( 'news', 'title' )->ignore( $page->id )],
            'content'  => ['required'],
            'slug' => ['required', Rule::unique( 'news', 'slug' )->ignore( $page->id )],

        ]);

        $attributes['content'] = mx_sanitize_content( $attributes['content'] );

        $page->update( $attributes );

        return $page;

    }

    public function getAvailablePages()
    {

        return Page::where( 'status', 'publish' )
            ->orderBy( 'id', 'desc' )
            ->get();
        
    }

}
