<?php

namespace App\Infrastructure\Models;

use Laravel\Passport\RefreshToken as PassportRefreshToken;

class RefreshToken extends PassportRefreshToken
{
    protected $connection = 'mysql_user';

    protected $table = 'oauth_refresh_tokens';
}
