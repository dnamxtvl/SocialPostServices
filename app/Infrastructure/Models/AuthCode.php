<?php

namespace App\Infrastructure\Models;

use Laravel\Passport\AuthCode as PassportAuthCode;

class AuthCode extends PassportAuthCode
{
    protected $connection = 'mysql_user';

    protected $table = 'oauth_auth_codes';
}
