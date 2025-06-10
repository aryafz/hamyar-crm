<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## سیستم مدیریت ارتباط با مشتری فارسی

این مخزن یک اسکلت اولیه برای راه‌اندازی سامانه مدیریت مشتریان، سفارش‌ها و پروژه‌ها به زبان فارسی است. پروژه بر پایه فریم‌ورک **Laravel 10** پیاده‌سازی شده و امکان گسترش ماژول‌های مختلف را برای شما فراهم می‌کند.

### پیش‌نیازها
- PHP 8.1 یا بالاتر به همراه [Composer](https://getcomposer.org)
- Node.js 18 به همراه npm
- پایگاه داده MySQL یا سازگار با تنظیمات `.env`

### نصب و راه‌اندازی سریع
1. مخزن را کلون کرده و وارد دایرکتوری اصلی شوید:
   ```bash
   git clone <repository-url>
   cd hamyar-crm
   ```
2. اجرای اسکریپت زیر، وابستگی‌های PHP را نصب کرده و فایل پیکربندی `.env` را ایجاد می‌کند:
   ```bash
   ./setup.sh
   ```
3. تنظیم مقادیر اتصال پایگاه داده در فایل `crm/.env` متناسب با محیط خود.
4. ساخت جداول پایگاه داده:
   ```bash
   php artisan migrate
   ```
5. اجرای سرور محلی:
   ```bash
   php artisan serve
   ```
   اکنون برنامه در آدرس `http://localhost:8000` در دسترس است.

### توسعه رابط کاربری
1. نصب بسته‌های جاوااسکریپت:
   ```bash
   npm install
   ```
2. برای توسعه و کامپایل خودکار منابع:
   ```bash
   npm run dev
   ```
3. ساخت نسخه بهینه قبل از استقرار:
   ```bash
   npm run build
   ```
   فایل‌های خروجی در `public/build` قرار می‌گیرند و توسط **Vite** بارگذاری می‌شوند.

### اجرای تست‌ها
برای اطمینان از صحت عملکرد بخش‌های مختلف می‌توانید تست‌ها را اجرا کنید:
```bash
php artisan test
```

### نکات تکمیلی
- دایرکتوری `public` را در وب‌سرور (Nginx یا Apache) به عنوان روت سایت تنظیم کنید.
- پس از تغییر تنظیمات محیط، اجرای دستورات زیر توصیه می‌شود:
  ```bash
  php artisan config:cache
  php artisan route:cache
  ```
