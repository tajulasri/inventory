<?php

namespace App\Http\Controllers;

use App\FileManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use App\EzOrder\FileUploadHelper;

class ImageController extends Controller
{
    protected $images;
    protected $filesystem;

    const VIEW_PATH = 'gallery.';

    public function __construct(FileManager $images,Filesystem $filesystem)
    {
        $this->images = $images;
        $this->filesystem = $filesystem;
    }

    public function index() {
        $items = $this->images->orderBy('id','desc')->paginate(10);
        if(view()->exists(self::VIEW_PATH.'index')) {
            return view(self::VIEW_PATH.'index')->with(compact('items'));
        }
    }

    public function upload(Request $request,ImageManager $manager,Filesystem $filesystem)
    {
        if(count($request->file('file')) > 0 ) {
            foreach($request->file('file') as $file) {
                $uploadFile = new FileUploadHelper($file);
                $uploadFile->workingWithDir($filesystem);
                $uploadFile->enableResizing($manager);

                if (!$uploadFile->isAllow()) {
                    return redirect()->back()->with(self::ERROR_KEY, self::ERROR_MESSAGE);
                }

                $uploadFile->upload();

                $fileManager = new FileManager();
                $fileManager->file_path = trim($uploadFile->getYear().DIRECTORY_SEPARATOR.$uploadFile->getAfterRename());
                $fileManager->original_name = $file->getClientOriginalName();
                $fileManager->save();

            }
            return redirect()->back()->with(self::SUCCESS_KEY, self::SUCCESS_MESSAGE);
        }
    }

    public function delete($images)
    {
        try {

            $images = FileManager::where('id',$images);
            if($images->count()) {
                $getImage = $images->first();
                $fullPath = public_path('images').DIRECTORY_SEPARATOR.$getImage->file_path;
                $images->delete();

                return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);
            }
        }
        catch (FileNotFoundException $e) {

            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }
    }
}
