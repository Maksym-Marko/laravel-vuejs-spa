<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Image;

class ImageUploadController extends Controller
{
    
    public function index()
    {

    }

    public function saveImage( Request $request )
    {

        $dir = 'images/';

        $imageFolder = public_path( $dir );

        $temp = current( $_FILES );

        if ( is_uploaded_file( $temp['tmp_name'] ) ) {

            // Sanitize input
            if ( preg_match( "/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'] ) ) {

                throw new \Exception( "HTTP/1.1 400 Invalid file name." );

                return;

            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {

                throw new \Exception( "HTTP/1.1 400 Invalid extension." );

                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $file_name = Str::random() . '-' . $temp['name'];

            $filetowrite = $imageFolder . $file_name;

            if( !File::exists( $imageFolder ) ) {

                File::makeDirectory( $imageFolder, 0755, true );

            }

            move_uploaded_file( $temp['tmp_name'], $filetowrite );

            $relativePath = '/' . $dir . $file_name;

            Image::create( [
                'file_name' => $file_name,
                'rel_path' => $relativePath,
                'user_id' => auth()->id()
            ] );

            return json_encode( [ 'location' => $file_name ] );

        }

        return 'File Upload. Unexpected error.';

    }

}
