<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### Clone Project
```
git clone https://github.com/asyrofil-ula/ecommerce.git
```
```
cd ecommerce
```
## Setup Project
- install package 
```
composer install
npm install
```
- copy .env.example to .env
```
cp .env.example .env
```
- generate APP_KEY
```
php artisan key:generate
```
- migrate database
```
php artisan migrate
```
- make admin user
```
php artisan db:seed --class=AdminTableSeeder
```
- setup midtrans according to your account 
```
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=
MIDTRANS_MERCHANT_ID=
```

### Run Project
- Server
```
php artisan serve
```
- Frontend
```
npm run dev
```

