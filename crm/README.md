<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## سیستم مدیریت ارتباط با مشتری فارسی

این پروژه یک اسکلت اولیه برای راه‌اندازی سامانه مدیریت مشتریان، سفارش‌ها و پروژه‌ها به زبان فارسی است. ساختار بر پایه فریم‌ورک Laravel پیاده‌سازی شده تا بتوانید ماژول‌های مختلف مانند ثبت مشتری، مدیریت سفارش و پروژه را گسترش دهید.

### توسعه پروژه

در نسخهٔ فعلی از **Laravel API Resources** برای قالب‌بندی پاسخ‌ها استفاده شده است تا خروجی تمامی APIها ساختاری یکنواخت و حرفه‌ای داشته باشد. برای راه‌اندازی پروژه مراحل زیر را انجام دهید:

1. برای آماده‌سازی پروژه اسکریپت `../setup.sh` را اجرا کنید تا وابستگی‌ها نصب و فایل `.env` ایجاد شود.
2. ایجاد پایگاه داده و اجرای دستور `php artisan migrate`
3. اجرای سرور محلی با `php artisan serve`


## Front-end

برای توسعه رابط کاربری، ابتدا وابستگی‌های جاوااسکریپت را نصب کنید:

```bash
npm install
```

در حالت توسعه دستور زیر را اجرا کنید تا فایل‌ها به‌صورت خودکار کامپایل شوند:

```bash
npm run dev
```

قبل از استقرار پروژه، نسخه بهینه را بسازید:

```bash
npm run build
```

فایل‌های خروجی در مسیر `public/build` قرار می‌گیرند و از طریق Vite بارگذاری می‌شوند.
