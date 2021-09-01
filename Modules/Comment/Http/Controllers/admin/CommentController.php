<?php

namespace Modules\Comment\Http\Controllers\admin;



use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Comment;

class CommentController extends  Controller
{
    public function __construct()
    {
        $this->middleware("can:show-comments")->only(['index']);
        $this->middleware("can:approve-comment")->only(['unapprovedComments','update']);
        $this->middleware("can:delete-comment")->only(['destroy']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $comments = Comment::where("approved",1)->latest()->paginate(20);
        return view("comment::admin.all",["comments"=>$comments]);
    }

    /**
     * go to unapproved comments page
     *
     * @return Application|Factory|View
     */
    public function unapprovedComments()
    {
        $comments = Comment::where("approved",0)->latest()->paginate(20);
        return \view("comment::admin.unapproved",compact("comments"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(Request $request,Comment $comment): RedirectResponse
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
