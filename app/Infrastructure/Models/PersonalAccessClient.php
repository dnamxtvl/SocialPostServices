<?php

namespace App\Infrastructure\Models;

use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    protected $connection = 'mysql_user';

    protected $table = 'oauth_personal_access_clients';
}
