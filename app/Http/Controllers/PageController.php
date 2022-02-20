<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    
    public function index()
    {

        return Page::all();
        
    }

    public function show( $slug )
    {

        $pages = DB::table( 'pages' )
            ->where( 'slug', $slug )
            ->where(  'status', 'publish'  )
            ->get(); // faster then "->first()"

        if( ! isset( $pages[0] ) ) {

            return $pages;

        }
            
        $pages[0]->content = htmlspecialchars_decode( $pages[0]->content );

        return $pages[0];

        

    }

}
