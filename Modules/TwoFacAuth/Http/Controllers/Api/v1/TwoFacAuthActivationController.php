<?php

namespace Modules\TwoFacAuth\Http\Controllers\Api\v1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\TwoFacAuth\Entities\ActiveCode;
use Symfony\Component\HttpFoundation\Response;

class TwoFacAuthActivationController extends Controller
{
    /**
     * send code to user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendCode(Request $request): JsonResponse
    {
        //validation
        $validator = Validator::make($request->all(),[
            'type'=>['required',Rule::in(['sms'])],
            'phone_number'=>['required','numeric',Rule::unique('users','phone_number')->ignore($request->user()->id)]
        ]);

        if($validator->fails()){
            return response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error'
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        //generate a 6-digits code for user
        $code = ActiveCode::generateCode($request->user());

        //TODO send code to user

        return response()->json([
            'data'=>[
                'code'=>$code,
            ]
        ]);

    }

    /**
     * activate tow-factor authentication
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function activateTwoFacAuth(Request $request): JsonResponse
    {
        //code validation
        $validator = Validator::make($request->all(),[
            'phone_number'=>['required','numeric',Rule::unique('users','phone_number')->ignore($request->user()->id)],
            'code'=>['required','numeric'],
        ]);

        if($validator->fails()){
            return response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error'
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $validator->getData();

        //code verification
        if(ActiveCode::verifyCode($validatedData['code'],auth()->user())){
            $request->user()->update([
                'type'=>'sms',
                'phone_number'=>$validatedData['phone_number']
            ]);
        }else{
            return \response()->json([
                'data'=>[
                    'message'=>'code verification failed',
                    'status'=>'error'
                ]
            ],Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        //delete code from database
        $code = ActiveCode::whereCode($validatedData['code'])->first();
        $code->delete();

        return \response()->json([
            'data'=>[
                'message'=>'code verified',
                'status'=>'success',
            ]
        ],200);

    }

    /**
     * deactivate tow-factor authentication
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deactivateTwoFacAuth(Request $request): JsonResponse
    {
        //validation
        $validator = Validator::make($request->all(),[
            'type'=>['required',Rule::in(['off'])],
        ]);

        if($validator->fails()){
            return response()->json([
                'data'=>[
                    'message'=>$validator->errors(),
                    'status'=>'error'
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->user()->update([
            'type'=>'off'
        ]);

        return \response()->json([
            'data'=>[
                'message'=>'two-factor authentication disabled',
                'status'=>'success'
            ]
        ],200);
    }
}
