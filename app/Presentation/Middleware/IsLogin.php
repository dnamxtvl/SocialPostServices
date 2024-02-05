<?php

namespace App\Presentation\Middleware;

use App\Application\Responses\RespondWithJsonErrorTrait;
use App\Infrastructure\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Horizon\Exceptions\ForbiddenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class IsLogin
{
    use RespondWithJsonErrorTrait;

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $checkLogin = Http::acceptJson()->withHeaders([
                'Authorization' => 'Bearer '.$request->bearerToken(),
            ])->post(config('auth.url').config('auth.path_call_api.check_login'));

            if (! $checkLogin->successful()) {
                Log::error($checkLogin->json()['message']);
                throw new ForbiddenException(Response::HTTP_INTERNAL_SERVER_ERROR, 'Đã xảy ra lỗi!');
            }

            if ($checkLogin->unauthorized()) {
                if (Auth::check()) {
                    Auth::logout();
                }
                throw new AuthenticationException('Phiên đăng nhập đã hết hạn');
            }

            $user = $checkLogin->json();
            $authUser = User::query()->find(id: $user['id']);

            if (is_null($authUser)) {
                throw new NotFoundHttpException('Không tìm thấy người dùng');
            }

            /** @var User $authUser */
            if (! Auth::check()) {
                Auth::login(user: $authUser);
            }

            return $next($request);
        } catch (Throwable $th) {
            return $this->respondWithJsonError(e: $th);
        }
    }
}
