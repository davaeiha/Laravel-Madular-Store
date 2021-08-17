<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;

    protected $table = "active_codes";


    public $timestamps = false;
    protected $fillable=[
        "code",
        'user_id',
        "expired_at"
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateCode($query,$user){
        if($UnexpiredCode = $this->UnexpiredCodeExistance($user)){
            $code = $UnexpiredCode;
        }else{
            do{
                $code = mt_rand(100000,999999);
            }while($this->checkRepeatitionOfCode($code));

            $user->activeCode()->create([
                "code" => $code,
                "user_id"=>$user->id,
                "expired_at"=>now()->addMinute(10)
            ]);

        }
        return $code;
    }


    private function checkRepeatitionOfCode($code)
    {
        return !! ActiveCode::where('code',$code)->first();
    }

    private function UnexpiredCodeExistance($user)
    {
        return $user->activeCode()->where("expired_at",'>',now())->value("code");
    }

    public function scopeVerifyCode($query,$code,$user){
        return !! $user->activeCode()->where('code',$code)->first();
    }

}
