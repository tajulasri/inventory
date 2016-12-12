<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{

    private $filesystem;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->middleware('auth');
        $this->filesystem = $filesystem;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function streamImage(Request $request)
    {
        //stupid image api
        $realPath = base64_decode($request->x);

        if(empty($request->x)) {

            return response()->json(['_Error' => 'Image not found']);
        }

        $path = public_path('images').DIRECTORY_SEPARATOR.$realPath;
        $img = Image::make($path);
        // create response and add encoded image data
        $response = Response::make($img->encode('png'));

        // set content-type
        $response->header('Content-Type', 'image/png');

        // output
        return $response;
    }
}
