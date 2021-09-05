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

class TwoFacAuthLoginController extends Controller
{
    /**
     * login via two-factor authentication
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginViaTwoFac(Request $request): JsonResponse
    {
        auth()->logout();

        if($request->user()->type !== 'sms'){
            return \response()->json([
                'data'=>[
                    'message'=>'2FA is disabled',
                    'status'=>'error'
                ]
            ]);
        }

        //code validation
        $validator = Validator::make($request->all(),[
            'phone_number'=>['required','numeric'],
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
        if(ActiveCode::verifyCode($validatedData['code'],$request->user())){
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
//        $code = ActiveCode::whereCode($validatedData['code'])->first();
//        $code->delete();

//        auth()->loginUsingId(auth()->user()->id);

        return \response()->json([
            'data'=>[
                'message'=>'code verified',
                'status'=>'success',
            ]
        ],200);
    }
}
