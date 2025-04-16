# BTS.id Technical Test by Ari Sawali

## Techstack
 - Laravel
 - Auth [[JWTAuth](https://github.com/tymondesigns/jwt-auth)]

### Prerequisites
- PHP >= 8.2
- Composer
- SQLite3
- Node.js and npm

## Install composer & Add .env & Migrate & Install JWTAuth Secret

```bash
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan jwt:secret

valet link
```


# API Documentation:

[Documentation](https://documenter.getpostman.com/view/32612793/2sB2cbaeCS)
