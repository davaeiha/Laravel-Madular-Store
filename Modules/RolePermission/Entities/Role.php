<?php namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Entities\User;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static latest()
 * @method static create(array $array)
 */
class Role extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table="roles";

    /**
     * @var string[]
     */
    protected $fillable=[
        "name",
        "label"
    ];

    /**
     * accessing permissions of a role
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * accessing users of a role
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
