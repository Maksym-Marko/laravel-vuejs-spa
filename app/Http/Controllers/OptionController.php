<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;

class OptionController extends Controller
{

    public function getHomePage()
    {

        return Option::where( 'name', 'homePageId' )->first();

    }
    
    public function setOptions( Request $request )
    {

        $attributes = request()->validate( [
            'homePageId' => ['required', 'integer']
        ] );

        foreach ( $attributes as $key => $value ) {
            
            $this->createOrUpdateOption( $key, $value );

        }

        return 'updated';

    }

    public function createOrUpdateOption( $option_name, $option_value )
    {

        $option = Option::where( 'name', $option_name )->get();

        if( isset( $option[0] ) ) {

            // update
            $opt = Option::where( 'name', $option_name )->first();

            $opt->update( [
                'name' => $option_name,
                'value' => $option_value
            ] );

        } else {

            // create
            Option::create( [
                'name' => $option_name,
                'value' => $option_value
            ] );

        }

        return true;

    }

}
