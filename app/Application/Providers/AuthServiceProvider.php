<?php

namespace App\Application\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Infrastructure\Models\AuthCode;
use App\Infrastructure\Models\Client;
use App\Infrastructure\Models\PersonalAccessClient;
use App\Infrastructure\Models\RefreshToken;
use App\Infrastructure\Models\Token;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //        Passport::withoutCookieSerialization();
        //        $this->registerPolicies();
        //        Passport::$ignoreCsrfToken = true;
        //        Passport::useTokenModel(Token::class);
        //        Passport::useClientModel(Client::class);
        //        Passport::useAuthCodeModel(AuthCode::class);
        //        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        //        Passport::useRefreshTokenModel(RefreshToken::class);
    }
}
