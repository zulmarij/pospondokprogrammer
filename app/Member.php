<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\PasswordResetNotification;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\FormatDate;
class Member extends Model
{
    //
}
