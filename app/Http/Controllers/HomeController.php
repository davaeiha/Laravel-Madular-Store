<?php

namespace App\Http\Controllers;

use App\Models\Product;
use http\Env\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
    }

    public function comment(Request $request){

        if(!$request->ajax()){
            return response()->json([
                "status"=>"just ajax request"
            ]);
        }


        $validatedData  = $request->validate([
            "comment"=>"required",
            "commentable_id"=>"required",
            "commentable_type"=>"required",
            "parent_id"=>"required"
        ]);

        if($validatedData["parent_id"] != 0){

        }

        $request->user()->comments()->create($validatedData);
        alert()->success("نظر شما با موفقیت ثبت شد");
         return back();

    }
}
