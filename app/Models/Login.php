<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Login extends Authenticatable implements CanResetPassword
{
    use HasFactory, CanResetPasswordTrait;

    protected $table = 'tbl_adminlogin';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'admin_id',
        'username',
        'email',
        'password',
        'status',
        'adminuser_id'
    ];

    /**
     * Get the email address that should be used for password reset.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    protected $hidden = [
        'password',
    ];
}
