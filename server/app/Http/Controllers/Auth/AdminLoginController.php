<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

final class AdminLoginController extends Controller
{
    public function __construct(private AuthManager $auth)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param AdminLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function __invoke(AdminLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if ($this->auth->guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => '認証に成功しました',
            ]);
        }

        throw new AuthenticationException('認証に失敗しました');
    }
}
