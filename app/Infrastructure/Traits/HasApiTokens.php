<?php

namespace App\Infrastructure\Traits;

use App\Infrastructure\Models\Client;
use App\Infrastructure\Models\Token;
use Illuminate\Container\Container;
use Laravel\Passport\PersonalAccessTokenFactory;

trait HasApiTokens
{
    protected $accessToken;

    public function clients()
    {
        return $this->hasMany(Client::class, 'user_id');
    }

    public function tokens()
    {
        return $this->hasMany(Token::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function token()
    {
        return $this->accessToken;
    }

    public function tokenCan($scope)
    {
        return $this->accessToken ? $this->accessToken->can($scope) : false;
    }

    public function createToken($name, array $scopes = [])
    {
        return Container::getInstance()->make(PersonalAccessTokenFactory::class)->make(
            $this->getKey(), $name, $scopes
        );
    }

    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
