<?php namespace app\Http\Controllers;

/**
 * Loans - Files Manager Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Requests;
use app\Http\Controllers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\File;
use Image;

class FileController extends Controller
{
    public function img(Request $request, $type, $file='')
    {
        if (!$this->valid('img', $file)) {
            return $this->notFound();
        }

        #if you need security add it here
        #can validate here alternative default pictures
        $this->showImg("img/$type/$file", ['w' => $request->get('w'), 'h' => $request->get('h')]);
    }

    #validation functions
    protected function valid($type, $file)
    {
        switch ($type) {
            case 'img': return preg_match('/\.(gif|png|jpe?g)$/', $file);
        }
        return true;
    }
    protected function notFound()
    {
        abort(404);
    }
    private function showFile($file, $default='')
    {
        $path=((!file_exists($path)) ? public_path() : storage_path()).'/files';

        if (!file_exists("$path/$file") || !is_file("$path/$file")) {
            return $this->notFound();
        }
        $finfo=finfo_open(FILEINFO_MIME_TYPE);
        header('Content-Type: '.finfo_file($finfo, "$path/$file"));
        readfile("$path/$file");
    }

    private function showImg($file, $resize=[])
    {
        $path=((!file_exists($path)) ? public_path() : storage_path()).'/files';

        $pathFile = $this->imgExist($path, $file, $resize);

        if (!$pathFile) {
            $pathFile = $path.'/img/no-image.jpg';
        }

        $imginfo = getimagesize($pathFile);
        $length = filesize("$path/$file");
        header("Content-type: ".$imginfo['mime']);
        header ("content-length: $length"); 
        readfile($pathFile);

        //$image = Image::make($pathFile);
        //return $image->response();
    }
    /**
     * [imgExist Check if the img exist, if exist and $size is charge, make the thumb if it dont exist]
     * @param  [type] $path [image Relative path]
     * @param  [type] $file [image file name]
     * @param  array  $size [size of thumb]
     * @return [String or false] [route of the img or false]
     */
    private function imgExist($path, $file, $size=[])
    {
        if (count($size)) {
            $w = isset($size['w']) ? $size['w'] : false;
            $h = isset($size['h']) ? $size['h'] : false;
            $ext = explode('.', $file);
            $ext = $ext[count($ext)-1];
            $name = rtrim($file, '.'.$ext);
            $pathFile = $path."/".$name.($w?'_w'.$w:'').($h?'_h'.$h:'').'.'.$ext;
        } else {
            $pathFile = "$path/$file";
        }

        if (!file_exists($pathFile) || !is_file($pathFile)) {
            if (file_exists("$path/$file") && is_file("$path/$file") && count($size)) {
                $img = \Image::make("$path/$file")->resize($w ? $w : null, $h ? $h : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save($pathFile);

                return $pathFile;
            }

            return false;
        }

        return $pathFile;
    }
}
