<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class DownloadController extends Controller
{
    public function downloadPublic($file){

        return Storage::disk('public')->download(\request('path').'/'.$file);
    }

    protected function getFile($file){
        $array = explode('/',$file->url);
        $size = sizeof($array);
        return $array[$size-1];
    }

    protected function path($file){
        $array = explode('/',$file->url);
        array_shift($array);
        array_pop($array);
        return implode('/',$array);
    }

    public function safeLink($file){
        return URL::temporarySignedRoute('download.file',now()->addMinute(2),['file'=>$this->getFile($file),'path'=>$this->path($file)]);
    }


    public function searchFile($file){

        $publicFiles = collect(Storage::disk('public')->files());
        $publicFiles->each(function($publicFile) use ($file) {
//            if(preg_match("/^{$file}$/",$publicFile)){
//                return
//            }
        });
        $publicDirectories = collect(Storage::disk('public')->directories());

        dd($publicFiles);
//        foreach($publicFiles as $publicFile){
//            if(preg_match("/^{$file}$/",$publicFile)){
//
//            }
//        }
        dd(preg_grep("/^{$file}dsa$/",$publicFiles));


//        dd($publicFiles);
//        dd($publicDirectories);



    }
}
