<?php

namespace Modules\Recaptcha\Rules;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws GuzzleException
     */
    public function passes($attribute, $value): bool
    {
        try {
            //send data including recaptcha token to google for verification
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

        }catch(\Exception $exception){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'شما به عنوان ربات تشخیص داده شدید.';
    }
}
