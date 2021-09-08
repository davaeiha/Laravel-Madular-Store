<?php namespace App\Models;


use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\CategoryProduct\Entities\Product;
use Modules\Comment\Entities\Comment;
use Modules\Discount\Entities\Discount;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;
use Modules\OrderPayment\Entities\Order;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\TwoFacAuth\Entities\ActiveCode;

/**
 * @method static where(string $string, int $int)
 * @method static latest()
 * @method static findOrFail(mixed $get)
 * @method static create(array $array)
 * @property mixed permissions
 * @property mixed roles
 * @property mixed $notificationRelations
 */
class User extends Authenticatable implements  MustVerifyEmail
{
    use HasFactory, Notifiable;


    /**
     * @var string
     */
    protected $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone_number',
        'api_token',
        'is_supervisor',
        'is_staff'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * check if a user is supervisor
     * @return bool
     */
    public function is_supervisor(): bool
    {
        if ($this->is_supervisor === 1){
            return true;
        }

        return false;
    }

    /**
     *check if a user is staff
     *
     * @return bool
     */
    public function is_staff(): bool
    {
        if ($this->is_staff === 1){
            return true;
        }
        return false;
    }

    /**
     * Send the password reset notification.
     * @function sendPasswordResetNotification
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * shows if a user has a specific type of authentication
     * @function select2FacAuth
     * @param $key
     * @return bool
     */
    public function select2FacAuth($key): bool
    {
        return $this->type == $key;
    }

    /**
     * access active codes of a user
     * @function activeCodes
     * @return HasMany
     */
    public function activeCode(): HasMany
    {
        return $this->hasMany(ActiveCode::class);
    }

    /**
     * Description: شماره تلفن طرف چک میکنه
     *
     * @function hasEnabledType
     * @return bool
     */
    public function hasEnabledType(): bool
    {

        return !! $this->type !== "off";
    }

    /**
     *accessing user`s roles
     *
     * @function roles
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * accessing user`s permissions
     *
     * @function permissions
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * accessing  products have been registered ordered
     *
     * @function products
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    /**
     * access user`s comment
     *
     * @function comments
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * check if user has specific permission
     *
     * @param Permission $permission
     * @return bool
     */
    public function hasPermission(Permission $permission): bool
    {
        return !! $this->permissions->contains("name",$permission->name);
    }

    /**
     * check user`s permission by his/her roles
     *
     * @param Permission $permission
     * @return bool
     */
    public function hasRoleByPermission(Permission $permission): bool
    {

        return is_null($this->roles->intersect($permission->roles));
    }

    /**
     * check user have a permission by his/her permissions and roles both
     *
     * @param Permission $permission
     * @return bool
     */
    public function userAllowed(Permission $permission): bool
    {
        return !! $this->hasPermission($permission) || $this->hasRoleByPermission($permission);
    }

    /**
     * access user`s order
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * access user`s downloads
     *
     * @return HasMany
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    /**
     * access user`s discounts
     *
     * @return BelongsToMany
     */

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }

    /**
     * @return BelongsToMany
     */
    public function notificationRelations(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class)->withPivot('channel_id');
    }

    /**
     *  check user has a specific notification with a specific channel
     *
     * @param Notification $notification
     * @param Channel $channel
     * @return bool
     */
    public function checkNotificationChannel(Notification $notification,Channel $channel): bool
    {
            //check that user has this notification
        if(!$this->notificationRelations->contains($notification)){
            return false;
        }else{
            //check that this user`s notification has this channel
            $userSpecificNotifications = $this->notificationRelations->filter(function ($userNotification) use ($notification) {
                return $userNotification->id == $notification->id;
            });

            $status = $userSpecificNotifications->first(function ($userSpecificNotification) use ($channel) {
                return $userSpecificNotification->pivot->channel_id == $channel->id;
            });

            if(is_null($status)){
                return false;
            }
        }
        return true;
    }
}
