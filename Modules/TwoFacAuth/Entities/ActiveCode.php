<?php

namespace Modules\TwoFacAuth\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $code)
 * @method static verifyCode(mixed $token, mixed $user)
 * @method static generateCode(mixed $user)
 */
class ActiveCode extends Model
{
    use HasFactory;

    /**
     * table defined
     * @var string
     */
    protected $table = "active_codes";
    /**
     * timestamp finished
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable=[
        "code",
        'user_id',
        "expired_at"
    ];

    /**
     * specify user of an active code
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * make a random 6-digits code
     *
     * @param $query
     * @param $user
     * @return int
     */
    public function scopeGenerateCode($query,$user): int
    {
        if($UnexpiredCode = $this->UnexpiredCodeExistence($user)){
            $code = $UnexpiredCode;
        }else{
            do{
                $code = mt_rand(100000,999999);
            }while($this->checkRepetitionOfCode($code));

            $user->activeCode()->create([
                "code" => $code,
                "expired_at"=>now()->addMinute(10)
            ]);

        }
        return $code;
    }

    /**
     * check if the code is repetitive
     *
     * @param $code
     * @return bool
     */
    private function checkRepetitionOfCode($code): bool
    {
        return !! ActiveCode::where('code',$code)->first();
    }

    /**
     * check if user have unexpired code
     *
     * @param $user
     * @return mixed
     */
    private function UnexpiredCodeExistence($user)
    {
        return $user->activeCode()->where("expired_at",'>',now())->value("code");
    }

    /**
     * show code verification true or false for a user
     *
     * @param $query
     * @param $code
     * @param $user
     * @return bool
     */
    public function scopeVerifyCode($query, $code, $user): bool
    {
        return !! $user->activeCode()->where('code',$code)->first();
    }

}
