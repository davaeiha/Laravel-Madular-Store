<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $comments = Comment::where("approved",1)->latest()->paginate(20);
        return view("admin.comments.all",["comments"=>$comments]);
    }

    public function unapprovedComments(){
        $comments = Comment::where("approved",0)->latest()->paginate(20);
        return \view("admin.comments.unapproved",compact("comments"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,Comment $comment)
    {
        $comment->update([
            "approved"=>1
        ]);

        alert()->success("کامنت مورد نظر تایید شد.");
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();
        alert()->success("کامنت  مورد نظر با موفقیت حذف شد ");
        return back();
    }
}
