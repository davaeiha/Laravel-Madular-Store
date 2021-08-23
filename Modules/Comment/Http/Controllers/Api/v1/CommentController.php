<?php

namespace Modules\Comment\Http\Controllers\Api\v1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\CategoryProduct\Entities\Product;
use Modules\Comment\Transformers\Api\v1\Comment as CommentResource;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse|CommentResource
     */
    public function Comment(Request $request,Product $product){
        $validator = Validator::make($request->all(),[
            'comment'=>'required|string',
            'parent_id'=>'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error:not validate'
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        $comment = $product->comments()->create([
            'comment'=>$validatedData['comment'],
            'parent_id'=>$validatedData['parent_id'],
            'user_id'=>auth()->user()->id
        ]);

        return new CommentResource($comment);
    }
}
