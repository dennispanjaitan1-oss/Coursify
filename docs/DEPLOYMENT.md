# 🚀 Coursify Deployment Guide

**Last Updated**: May 29, 2026  
**Environment**: Production

---

## 📋 Table of Contents

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Server Requirements](#server-requirements)
3. [Environment Setup](#environment-setup)
4. [Database Migration](#database-migration)
5. [Code Deployment](#code-deployment)
6. [Post-Deployment Verification](#post-deployment-verification)
7. [Monitoring & Maintenance](#monitoring--maintenance)
8. [Troubleshooting](#troubleshooting)
9. [Rollback Procedure](#rollback-procedure)

---

## ✅ Pre-Deployment Checklist

```
□ Code review completed
□ All tests passing (min 70% coverage)
□ No console errors or warnings
□ .env.example updated
□ Database migrations tested locally
□ Static assets compiled (CSS, JS)
□ Security headers configured
□ HTTPS certificates ready
□ Backup strategy in place
□ Monitoring tools configured
□ Incident response plan reviewed
□ Team trained on deployment process
```

---

## 🖥️ Server Requirements

### Minimum Specifications

```
CPU:     2+ cores
RAM:     4GB minimum (8GB recommended)
Storage: 20GB SSD minimum
OS:      Ubuntu 20.04 LTS or higher
```

### Required Software

```
PHP:          8.2+
MySQL:        8.0+ or PostgreSQL 12+
Nginx/Apache: Latest stable
Node.js:      18+ (for frontend builds)
Composer:     2.0+
Git:          2.0+
Redis:        (optional, for caching)
```

### PHP Extensions

```
- bcmath
- ctype
- fileinfo
- json
- mbstring
- openssl
- pdo
- pdo_mysql
- pdo_pgsql
- tokenizer
- xml
- gd (for image manipulation)
```

---

## 🔧 Environment Setup

### 1. SSH Access & Initial Setup

```bash
# Connect to server
ssh deployer@production.server.com

# Create application directory
sudo mkdir -p /var/www/coursify
sudo chown deployer:www-data /var/www/coursify

# Navigate to directory
cd /var/www/coursify
```

### 2. Clone Repository

```bash
# Clone from Git
git clone https://github.com/yourusername/coursify.git .

# Or pull latest if already exists
git pull origin main
```

### 3. Create Environment File

```bash
# Copy example and configure
cp .env.example .env

# Edit with production values
nano .env
```

**Critical `.env` Variables**:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host.com
DB_PORT=3306
DB_DATABASE=coursify_prod
DB_USERNAME=coursify_user
DB_PASSWORD=STRONG_PASSWORD_HERE

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=app-password
MAIL_FROM_ADDRESS=noreply@coursify.local

# Timezone
APP_TIMEZONE=Asia/Jakarta

# Security
SECURE_HEADERS_ENABLED=true
SESSION_SECURE_COOKIES=true
SESSION_HTTP_ONLY=true

# Google OAuth
GOOGLE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=XXXXXXXX

# Redis (optional, for caching)
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# Pusher (for broadcasting)
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
```

⚠️ **IMPORTANT**: Keep `.env` file secure and never commit to Git!

### 4. Generate Application Key

```bash
php artisan key:generate --force
```

### 5. Set Directory Permissions

```bash
# Set correct ownership
sudo chown -R www-data:www-data /var/www/coursify

# Set directory permissions
sudo chmod -R 755 /var/www/coursify
sudo chmod -R 775 /var/www/coursify/storage
sudo chmod -R 775 /var/www/coursify/bootstrap/cache

# Set storage write permissions
sudo chmod -R 777 /var/www/coursify/storage
sudo chmod -R 777 /var/www/coursify/bootstrap/cache
```

---

## 🗄️ Database Migration

### 1. Create Database User

```sql
-- Connect to MySQL as root
mysql -u root -p

-- Create database and user
CREATE DATABASE coursify_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'coursify_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';
GRANT ALL PRIVILEGES ON coursify_prod.* TO 'coursify_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Install Dependencies

```bash
cd /var/www/coursify

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
npm install --production
npm run build
```

### 3. Run Migrations

```bash
# Run all migrations
php artisan migrate --force

# Verify migrations
php artisan migrate:status

# Create admin user (optional)
php artisan tinker
# In tinker shell:
# >>> $user = new App\Models\User;
# >>> $user->name = 'Admin';
# >>> $user->email = 'admin@coursify.local';
# >>> $user->password = Hash::make('AdminPassword123!');
# >>> $user->role = 'admin';
# >>> $user->save();
# >>> exit
```

### 4. Seed Database (Optional)

```bash
# Run seeders for initial data
php artisan db:seed --class=DatabaseSeeder

# Or specific seeder
php artisan db:seed --class=CourseSeeder
```

---

## 📦 Code Deployment

### 1. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 2. Configure Web Server

#### Nginx Configuration

```nginx
# /etc/nginx/sites-available/coursify
server {
    listen 80;
    listen [::]:80;

    server_name coursify.local www.coursify.local;
    root /var/www/coursify/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.env {
        deny all;
    }

    # Redirect HTTP to HTTPS (uncomment after SSL setup)
    # return 301 https://$server_name$request_uri;
}

# HTTPS Configuration (after SSL setup)
# server {
#     listen 443 ssl http2;
#     listen [::]:443 ssl http2;
#     ssl_certificate /etc/letsencrypt/live/coursify.local/fullchain.pem;
#     ssl_certificate_key /etc/letsencrypt/live/coursify.local/privkey.pem;
#     # ... rest of configuration
# }
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/coursify /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### Apache Configuration (Alternative)

```apache
# /etc/apache2/sites-available/coursify.conf
<VirtualHost *:80>
    ServerName coursify.local
    ServerAlias www.coursify.local
    DocumentRoot /var/www/coursify/public

    <Directory /var/www/coursify>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/coursify-error.log
    CustomLog ${APACHE_LOG_DIR}/coursify-access.log combined
</VirtualHost>
```

Enable:

```bash
sudo a2enmod rewrite
sudo a2ensite coursify.conf
sudo systemctl restart apache2
```

### 3. SSL/HTTPS Setup (Let's Encrypt)

```bash
# Install certbot
sudo apt-get install certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d coursify.local -d www.coursify.local

# Auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

### 4. Optimize Production

```bash
# Generate optimized autoloader
composer dump-autoload --optimize

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize
php artisan optimize
```

---

## ✔️ Post-Deployment Verification

### 1. Health Checks

```bash
# Test application
curl -I https://coursify.local

# Check PHP version
php -v

# Verify environment
php artisan config:show

# Test database connection
php artisan tinker
# >>> DB::connection()->getPdo()
```

### 2. Smoke Tests

```bash
# Run quick tests
php artisan test --group=smoke

# Check critical endpoints
curl -I https://coursify.local/
curl -I https://coursify.local/api/courses
curl -I https://coursify.local/login
```

### 3. Log Monitoring

```bash
# Watch logs for errors
tail -f storage/logs/laravel.log

# Check system logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/php8.5-fpm.log
```

### 4. Performance Check

```bash
# Check response times
time curl https://coursify.local/

# Monitor resources
top
free -h
df -h
```

---

## 📊 Monitoring & Maintenance

### 1. Automated Backups

```bash
# Create backup script: /usr/local/bin/backup-coursify.sh
#!/bin/bash

BACKUP_DIR="/backups/coursify"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup database
mysqldump -u coursify_user -p coursify_prod | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/coursify

# Keep only last 30 days
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

Schedule with cron:

```bash
# Run daily at 2 AM
0 2 * * * /usr/local/bin/backup-coursify.sh
```

### 2. Log Rotation

```bash
# /etc/logrotate.d/coursify
/var/www/coursify/storage/logs/laravel*.log {
    daily
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
}
```

### 3. Monitoring Tools

Recommended tools:

- **Uptime**: Uptimerobot, Statuspage
- **Errors**: Sentry, Rollbar
- **Performance**: New Relic, DataDog
- **Logs**: ELK Stack, Papertrail
- **Metrics**: Prometheus, Grafana

### 4. Regular Tasks

```bash
# Clear old logs (monthly)
php artisan logs:clear

# Refresh cache (weekly)
php artisan cache:clear

# Check for updates (weekly)
composer update --dry-run

# Monitor disk space
watch -n 60 'df -h'
```

---

## 🐛 Troubleshooting

### Application Errors

**500 Error - Check Logs**

```bash
tail -f storage/logs/laravel.log
```

**Database Connection Error**

```bash
# Test connection
php artisan db
# Or in MySQL
mysql -u coursify_user -p -e "SELECT 1"
```

**Permission Denied**

```bash
# Reset permissions
sudo chown -R www-data:www-data /var/www/coursify
sudo chmod -R 755 /var/www/coursify
sudo chmod -R 775 /var/www/coursify/storage
```

**Composer Issues**

```bash
# Clear cache and reinstall
composer clear-cache
composer install --no-dev
```

### Performance Issues

**Slow Queries**

```bash
# Enable slow query log
php artisan tinker
# >>> Cache::clear();
# >>> Artisan::call('queue:work');

# Check database indexes
SHOW INDEX FROM courses;
SHOW INDEX FROM enrollments;
```

**High Memory Usage**

```bash
# Check memory limits
php -i | grep memory_limit

# Increase if needed in php.ini
memory_limit = 512M
```

---

## 🔄 Rollback Procedure

If deployment fails or issues are discovered:

### 1. Immediate Rollback

```bash
cd /var/www/coursify

# Revert to previous commit
git revert HEAD
git push origin main

# Restart application
php artisan down
php artisan cache:clear
php artisan up
```

### 2. Database Rollback

```bash
# Check migration status
php artisan migrate:status

# Rollback last migration batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:rollback --batch=0
```

### 3. Restore from Backup

```bash
# Stop application
sudo systemctl stop nginx

# Restore database
gunzip < /backups/coursify/db_YYYYMMDD_HHMMSS.sql.gz | mysql -u coursify_user -p coursify_prod

# Restore files
cd /var/www
rm -rf coursify
tar -xzf /backups/coursify/files_YYYYMMDD_HHMMSS.tar.gz

# Restart
sudo systemctl start nginx
```

### 4. Notify Team

```bash
# Create incident notification
# - What happened
# - When it happened
# - What was rolled back
# - Status of service
# - Next steps
```

---

## 📞 Support Contacts

- **DevOps Team**: devops@coursify.local
- **Database Admin**: dba@coursify.local
- **Security Team**: security@coursify.local
- **Emergency**: +62-XXX-XXXXXXX

---

## 📝 Deployment Checklist

```bash
#!/bin/bash
# deployment-checklist.sh

echo "=== Pre-Deployment Checks ==="
echo "□ Tests passing"
echo "□ Code review approved"
echo "□ Database migrations tested"
echo ""

echo "=== Deployment Steps ==="
git pull origin main
composer install --no-dev --optimize-autoloader
npm install --production
npm run build

echo "=== Post-Deployment ==="
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Verification ==="
curl -I https://coursify.local
php artisan test --group=smoke

echo "=== Deployment Complete ==="
```

---

**Deployment Date**: [Insert date]  
**Deployed By**: [Insert name]  
**Deployment Time**: [Insert time]  
**Status**: ✅ Successful / ❌ Rolled Back

For questions or issues, contact the DevOps team.
