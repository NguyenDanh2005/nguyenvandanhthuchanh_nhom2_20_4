<?php

/*
 * Họ tên: Nguyễn Văn A
 * Mã sinh viên: 20201234
 * Lớp: D18CNPM2
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SocialAuthService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    public function __construct(private SocialAuthService $socialAuthService) {}

    /**
     * Chuyển hướng người dùng đến trang đăng nhập của provider (Google/Facebook).
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        if ($provider === 'facebook') {
            return Socialite::driver($provider)->setScopes(['public_profile'])->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Xử lý callback sau khi người dùng xác thực với provider.
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            \Log::error('Social login error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }

        // Xử lý trường hợp Facebook không trả email
        if (empty($socialUser->getEmail()) && $provider === 'facebook') {
            $user = User::where('provider', $provider)
                        ->where('provider_id', $socialUser->getId())
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name'        => $socialUser->getName() ?? 'Facebook User',
                    'email'       => $socialUser->getId() . '@facebook.com',
                    'provider'    => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar'      => $socialUser->getAvatar(),
                    'password'    => null,
                ]);
            }

            Auth::login($user, remember: true);
            return redirect()->route('dashboard');
        }

        if (empty($socialUser->getEmail())) {
            return redirect()->route('login')
                ->with('error', 'Không lấy được email từ tài khoản.');
        }

        $user = $this->socialAuthService->findOrCreateUser($socialUser, $provider);
        Auth::login($user, remember: true);

        return redirect()->route('dashboard');
    }

    /**
     * Đăng xuất người dùng.
     */
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Kiểm tra provider hợp lệ.
     */
    private function validateProvider(string $provider): void
    {
        if (! in_array($provider, ['google', 'facebook'])) {
            abort(404, 'Provider không hợp lệ.');
        }
    }
}
