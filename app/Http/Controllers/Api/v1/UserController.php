<?php namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\Api\v1\user as UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * login based on api service
     *
     * @param Request $request
     * @return JsonResponse|UserResource
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email|exists:users',
            'password'=>'required|min:3|max:20'
        ]);

        if($validator->fails()){
            return response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error',
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        if(!auth()->attempt($validatedData)){
            return \response()->json([
                'data'=>[
                    'message'=>'the password is wrong',
                    'status'=>'unauthorized'
                ]
            ],Response::HTTP_UNAUTHORIZED);
        }

        auth()->user()->update([
            'api_token'=>Str::random(100)
        ]);

        return new UserResource(auth()->user());
    }

    /**
     * register user based on api service
     *
     * @param Request $request
     * @return JsonResponse|UserResource
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:10',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:3|max:10'
        ]);

        if($validator->fails()){
            return \response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error'
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        $user = User::create([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>Hash::make($validatedData['password']),
            'api_token'=>Str::random(20)
        ]);

        return new UserResource($user);

    }
}
