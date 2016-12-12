<?php
namespace App\EzOrder;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class FileUploadHelper {

    private $httpFile;

    private $fileSystem;

    private $allowed = ['jpg','png','jpeg'];

    private $imageManager;

    public function __construct(UploadedFile $httpFile)
    {
        $this->httpFile = $httpFile;
    }

    public function upload()
    {
        if(! $this->fileSystem->exists($this->getAssetPath())) {
            @$this->fileSystem->makeDirectory($this->getAssetPath());
        }
        $img = $this->imageManager->make($this->httpFile);
        $img->resize(420,null,function($constraint){
            $constraint->aspectRatio();
        });
        $img->resizeCanvas(450,null);
        $img->trim();
        $img->save($this->getAssetPath().DIRECTORY_SEPARATOR.$this->getAfterRename());
    }

    public function isAllow() {
        $mime = explode('/', $this->httpFile->getMimeType());
        return in_array($mime[1],$this->allowed) ? true : false;
    }

    public function enableResizing(ImageManager $manager)
    {
        $this->imageManager = $manager;
    }

    public function workingWithDir(Filesystem $filesystem)
    {
        $this->fileSystem = $filesystem;
    }

    protected function resizeImage()
    {

    }

    public function getAfterRename()
    {
        return md5($this->httpFile->getClientOriginalName()).'.'.$this->httpFile->getClientOriginalExtension();
    }

    protected function getAssetPath()
    {
        return public_path('images').DIRECTORY_SEPARATOR.$this->getYear();
    }

    public function getYear()
    {
        return Carbon::now()->year;
    }


}