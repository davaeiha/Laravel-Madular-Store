<?php

namespace App\Rules;

use GuzzleHttp\Psr7\Request;
use http\Client;
use Illuminate\Contracts\Validation\Rule;

class recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $jsonResponse = $client->request("POST","https://www.google.com/recaptcha/api/siteverify",[
                "form_params"=>[
                    "secret"=>env("GOOGLE_RECAPTCHA_SECRET_KEY"),
                    "response"=> $value,
                    "remoteip"=>\request()->ip(),
                ]
            ]);

            $jsonResponse = json_decode($jsonResponse->getBody());

            return $jsonResponse->success;
//            dd($jsonResponse);
        }catch(\Exception $exception){
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you have been recognized as a robot';
    }
}
