<?php namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Entities\User;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static latest()
 * @method static create(array $validatedData)
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table="permissions";

    /**
     * @var string[]
     */
    protected $fillable=[
        "name",
        "label"
    ];

    /**
     * access roles of a permission
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * accessing users with one permission
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }



}
