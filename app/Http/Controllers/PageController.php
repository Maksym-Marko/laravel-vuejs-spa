<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    
    public function index()
    {

        return Page::all();
        
    }    

    public function show( $slug )
    {

        $pages = Page::where( [
            'slug'      => $slug,
            'status'    => 'publish'
        ] )->get();

        if( ! isset( $pages[0] ) ) {

            return $pages;

        }
            
        $pages[0]->content = htmlspecialchars_decode( $pages[0]->content );

        return $pages[0];        

    }

    public function getById( $id )
    {

        $page = Page::findOrFail( $id );

        if( ! isset( $page->content ) ) {

            return $page;

        }
            
        $page->content = htmlspecialchars_decode( $page->content );

        return $page;

    }

}
