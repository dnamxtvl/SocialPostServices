<?php

namespace App\Infrastructure\Models;

use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    protected $connection = 'mysql_user';

    protected $table = 'oauth_access_tokens';
}
