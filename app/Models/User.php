<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Modules\Discount\Entities\Discount;

class User extends Authenticatable implements  MustVerifyEmail
{
    use HasFactory, Notifiable,Searchable;

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

    public function is_supervisor(): bool
    {
        if ($this->is_supervisor === 1){
            return true;
        }

        return false;
    }

    public function is_staff(): bool
    {
        if ($this->is_staff === 1){
            return true;
        }

        return false;

    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function select2FacAuth($key): bool
    {
        return $this->type == $key;
    }

    public function activeCode(): HasMany
    {
        return $this->hasMany(ActiveCode::class);
    }

    /**
     * Description: شماره تلفن طرف چک میکنه
     *
     * @function hasEnabledType
     *
     * @return bool
     */
    public function hasEnabledType(): bool
    {

        return !! $this->type !== "off";
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function hasPermission(Permission $permission): bool
    {
        return !! $this->permissions->contains("name",$permission->name);
    }

    public function hasRoleByPermission(Permission $permission): bool
    {

        return is_null($this->roles->intersect($permission->roles));
    }

    public function userAllowed(Permission $permission): bool
    {
        return !! $this->hasPermission($permission) || $this->hasRoleByPermission($permission);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }


//    public function userAllowed($permission){
//        if($this->hasPermission($permission) || $this->hasRole($permission->roles)){
//            return true;
//        }
//
//        return false;
//    }

}
