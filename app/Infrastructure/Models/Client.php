<?php

namespace App\Infrastructure\Models;

use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    protected $connection = 'mysql_user';

    protected $table = 'oauth_clients';
}
