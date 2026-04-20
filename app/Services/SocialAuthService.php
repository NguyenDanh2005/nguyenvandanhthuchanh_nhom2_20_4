<?php

/*
 * Họ tên: Nguyễn Văn A
 * Mã sinh viên: 20201234
 * Lớp: D18CNPM2
 */

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialAuthService
{
    /**
     * Tìm hoặc tạo user từ thông tin OAuth provider.
     * Nếu email đã tồn tại → đăng nhập, chưa tồn tại → tạo mới.
     */
    public function findOrCreateUser(SocialUser $socialUser, string $provider): User
    {
        // Tìm theo provider_id trước
        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if ($user) {
            // Cập nhật avatar mới nhất
            $user->update(['avatar' => $socialUser->getAvatar()]);
            return $user;
        }

        // Tìm theo email nếu đã có tài khoản
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
            ]);
            return $user;
        }

        // Tạo tài khoản mới
        return User::create([
            'name'        => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
            'email'       => $socialUser->getEmail(),
            'provider'    => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar'      => $socialUser->getAvatar(),
            'student_id'  => null, // Sinh viên có thể cập nhật sau
            'password'    => null,
        ]);
    }
}
