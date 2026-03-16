# 1. Start with a blank computer that has PHP 8.2 installed
FROM php:8.4-cli

# 2. Install the necessary system tools (like ZIP extractors and downloaders)
RUN apt-get update -y && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl

# 3. Install the PHP extensions Laravel needs
RUN docker-php-ext-install pdo zip

# 4. Bring in the Composer tool
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Bring in Node.js and NPM (so we can build your Tailwind CSS!)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 6. Set up our main workspace folder inside this new computer
WORKDIR /app

# 7. Copy ALL your code from GitHub into this workspace
COPY . .

# 8. Run the PHP installation command
RUN composer install --no-dev --optimize-autoloader

# 9. Run the Javascript/Tailwind installation command and remove the dev-mode hot file
RUN npm install && npm run build && rm -f public/hot

# 10. Use file-based session & cache — no DB tables needed for these
ENV SESSION_DRIVER=file
ENV CACHE_STORE=file
ENV APP_ENV=production

# 11. Create the SQLite database file and fix storage permissions
RUN touch database/database.sqlite && \
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views && \
    chmod -R 775 storage bootstrap/cache

# 12. Open the port so Render can send visitors in
EXPOSE 10000

# 13. Clear cached config, run migrations, then start Laravel
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}