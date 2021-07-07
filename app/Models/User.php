<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastName',
        'firstName',
        'middleName',
        'email',
        'password',
        'contactNo',
        'houseNo',
        'street',
        'zipCode',
        'city',
        'province',
        'dob',
        'gender',
        'civilStatus',
        'citizenship'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'contactNo',
        'houseNo',
        'street',
        'zipCode',
        'city',
        'province',
        'dob'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function availedServices() {
        return $this->hasMany(AvailedServices::class);
    }

    public function transactions() {
        return $this->hasManyThrough(
            AvailedServices::class,
            Transaction::class,
            'availedServicesId', // Foreign Key in Transactions table
            'userId' //Foreign Key in AvailedServices table
        );
    }
}
