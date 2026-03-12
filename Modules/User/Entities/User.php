<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_picture_url',
    ];

    public function getRolesNamesAttribute()
    {
        return ucwords(str_replace('_', ' ', implode(', ', array_column($this->roles->toArray(), 'name'))));
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture && Storage::disk('elegant')->exists($this->profile_picture)) {
            return Storage::disk('elegant')->url($this->profile_picture);
        }

        return $this->profile_picture;
    }

    public function getUserPermissionsAttribute()
    {
        $permissions = [];

        foreach ($this->getAllPermissions() as $permission) {
            $permissions[] = $permission->name;
        }

        return $permissions;
    }

    public function getUserRolesAttribute()
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = $role->name;
        }

        return $roles;
    }
}
