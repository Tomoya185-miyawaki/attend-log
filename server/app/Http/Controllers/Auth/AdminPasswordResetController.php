<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminPasswordResetRequest;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

final class AdminPasswordResetController extends Controller
{
    public function __construct(
        private AuthManager $auth,
        private AdminRepositoryInterface $adminRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param AdminPasswordResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function __invoke(AdminPasswordResetRequest $request): JsonResponse
    {
        if ($this->auth->guard('admin')->check()) {
            throw new AuthenticationException('既にログインしています');
        }
        $admin = $this->adminRepositoryInterface->findByEmail($request->input('email') ?? '');
        if ($admin === null) {
            throw new AuthenticationException('メールアドレスが存在しません');
        }
        $admin->password = bcrypt($request->input('password'));
        $isUpdate = $this->adminRepositoryInterface->save($admin);
        if (!$isUpdate) {
            throw new AuthenticationException('パスワードの更新に失敗しました');
        }
        return response()->json([
            'message' => 'パスワードの更新に成功しました',
        ]);
    }
}
