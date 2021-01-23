<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'msisdn',
        'password',
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

    // // mutator
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = Hash::make($password);
    // }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleId)
    {
        return in_array($roleId, $this->roles->pluck('id')->toArray());
    }
    
    /**
     * Check if user has a role
     *
     * @param  mixed $role
     * @return bool
     */
    public function hasAnyRole(string $role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
    
    /**
     * Check if user has roles
     *
     * @param  mixed $role
     * @return bool
     */
    public function hasAnyRoles(array $role)
    {
        return null !== $this->roles()->whereIn('name', $role)->first();
    }

}
