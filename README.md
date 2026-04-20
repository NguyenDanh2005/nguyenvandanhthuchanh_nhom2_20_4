# Laravel Social Login – Đăng nhập Google & Facebook


- Họ tên: Nguyễn Văn Danh
- Mã sinh viên: 23810310136
- Lớp: D18CNPM2


> Thực hành 20/04/2026 – Lập trình Web Nâng Cao với XAMPP & Laravel  
> Chức năng đăng nhập bằng Google và Facebook sử dụng Laravel Socialite (OAuth 2.0)

---

## Cài đặt

### Yêu cầu
- PHP >= 8.2
- Composer
- XAMPP (MySQL đang chạy)
- Laravel 12.x

### Các bước

```bash
# 1. Clone hoặc copy thư mục dự án vào htdocs
# D:\xampp\htdocs\laravel-social-login

# 2. Cài dependencies
composer install

# 3. Tạo file .env
cp .env.example .env

# 4. Sinh APP_KEY
php artisan key:generate

# 5. Tạo database trong phpMyAdmin: social_login_db
# Sau đó chạy migration
php artisan migrate

# 6. Khởi động server
php artisan serve
```

Truy cập: http://localhost:8000

---

## Cấu hình Google OAuth

1. Vào [Google Cloud Console](https://console.cloud.google.com)
2. Tạo project mới → **APIs & Services** → **Credentials**
3. Tạo **OAuth 2.0 Client ID** (loại: Web application)
4. Thêm Authorized redirect URI:
   ```
   http://localhost:8000/auth/google/callback
   ```
5. Copy **Client ID** và **Client Secret** vào `.env`:
   ```env
   GOOGLE_CLIENT_ID=your-client-id
   GOOGLE_CLIENT_SECRET=your-client-secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

---

## Cấu hình Facebook OAuth

1. Vào [Facebook Developers](https://developers.facebook.com)
2. Tạo App mới → chọn **Consumer**
3. Thêm sản phẩm **Facebook Login** → **Settings**
4. Thêm Valid OAuth Redirect URI:
   ```
   http://localhost:8000/auth/facebook/callback
   ```
5. Vào **Settings** → **Basic** → copy **App ID** và **App Secret** vào `.env`:
   ```env
   FACEBOOK_CLIENT_ID=your-app-id
   FACEBOOK_CLIENT_SECRET=your-app-secret
   FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
   ```

---

## Cấu trúc code

```
app/
├── Http/Controllers/Auth/
│   └── SocialAuthController.php   # Xử lý redirect & callback OAuth
├── Models/
│   └── User.php                   # Model với các field: provider, provider_id, avatar, student_id
└── Services/
    └── SocialAuthService.php      # Logic tìm/tạo user từ OAuth

resources/views/
├── auth/login.blade.php           # Trang đăng nhập
└── dashboard.blade.php            # Trang sau khi đăng nhập

routes/web.php                     # Định nghĩa routes
config/services.php                # Cấu hình Google & Facebook
database/migrations/               # Migration bảng users (có student_id, provider, avatar)
```

---

## Luồng hoạt động

```
User click "Đăng nhập Google/Facebook"
    → redirect đến OAuth provider
    → User xác thực & cấp quyền
    → Provider callback về /auth/{provider}/callback
    → SocialAuthController::callback()
        → Socialite lấy thông tin user
        → SocialAuthService::findOrCreateUser()
            → Tìm theo provider_id → nếu có: đăng nhập
            → Tìm theo email → nếu có: liên kết & đăng nhập
            → Không có: tạo mới & đăng nhập
        → Auth::login($user)
        → Redirect về /dashboard
```

---

## Demo chức năng

- Trang đăng nhập: http://localhost:8000/login
- Nút **Đăng nhập với Google** → OAuth Google flow
- Nút **Đăng nhập với Facebook** → OAuth Facebook flow
- Sau đăng nhập: hiển thị tên, email, avatar, provider, mã sinh viên
- Nút **Đăng xuất** → xóa session, về trang login
