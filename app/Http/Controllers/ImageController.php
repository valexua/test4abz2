<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller {

    #[Http]
    protected object $client;

    
    function __construct(){

       $this->client = http::timeout(60)
                       ->withBasicAuth( env('API_NAME'), env('API_KEY') )
                       ->withoutVerifying();
       
       
       return $this;
    }
  

    function shrink_image($bin2 = null) {
        
        # step 1 send2api service

        $postUrl = "https://api.tinify.com/shrink";

        $bin = $bin2 ?? request()->getContent();

        $postImg = $this->client->withBody($bin, 'image/jpeg' )->post( $postUrl );
        
        //dd($postImg);
        //log::info('post res',[ $postImg ]);
        

        # step 2 shrink

        $url = json_decode( $postImg->body() )?->output?->url;

        $data = [ "resize" => 
            [
              "method" => "cover",
              "width"  => 70,
              "height" => 70
            ]
        ];

        $shrink_img = $this->client->asJson()->post( $url, $data );

        return response( $shrink_img->body() , 
                          $shrink_img->status(), 
                          $shrink_img->headers() );
    }

}

