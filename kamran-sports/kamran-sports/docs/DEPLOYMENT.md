# Deployment Guide - Hostinger Business Hosting

This guide will walk you through deploying Kamran Sports to your Hostinger Business Shared Hosting.

## Prerequisites

- Hostinger Business Shared Hosting account
- FTP/SFTP credentials from Hostinger
- MySQL database access from Hostinger control panel
- Domain configured (kamransports.pk)

## Step 1: Database Setup

### 1.1 Create MySQL Database via hPanel

1. Log in to your Hostinger hPanel
2. Navigate to **Databases** → **MySQL Databases**
3. Click **Create New Database**
4. Database name: `u123456789_kamran_sports` (use your username prefix)
5. Create database user with strong password
6. Grant all privileges to the user

### 1.2 Import Database Schema

1. In hPanel, go to **Databases** → **phpMyAdmin**
2. Select your newly created database
3. Click **Import** tab
4. Upload `/database/schema.sql`
5. Click **Go** to import

### 1.3 Note Database Credentials

```
DB_HOST: localhost (usually for Hostinger)
DB_NAME: u123456789_kamran_sports
DB_USER: u123456789_kamran_user
DB_PASS: [your_strong_password]
```

## Step 2: Backend Setup

### 2.1 Prepare Backend Files

On your local machine:

```bash
cd backend
cp config.example.php config.php
```

Edit `config.php` with your Hostinger database credentials:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456789_kamran_sports');
define('DB_USER', 'u123456789_kamran_user');
define('DB_PASS', 'your_password_here');
define('JWT_SECRET', 'generate-a-very-long-random-string-here');
define('APP_URL', 'https://www.kamransports.pk');
define('API_URL', 'https://www.kamransports.pk/api');
```

### 2.2 Upload Backend via FTP

Using FileZilla or Hostinger File Manager:

1. Connect to your hosting via FTP
2. Navigate to `public_html` directory
3. Create folder structure:
   ```
   public_html/
   ├── api/          (Upload entire backend folder here)
   ├── uploads/      (Create this folder, set permissions to 755)
   └── .htaccess
   ```
4. Upload all files from `backend/` to `public_html/api/`
5. Set `uploads/` directory permissions to 755

### 2.3 Configure .htaccess for API

Create `public_html/api/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /api/
    
    # Handle CORS
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type, Authorization"
    
    # Route all requests to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?request=$1 [QSA,L]
</IfModule>
```

## Step 3: Frontend Build & Upload

### 3.1 Build Frontend for Production

On your local machine:

```bash
cd frontend
npm install
npm run build
```

This creates a `dist/` folder with optimized production files.

### 3.2 Configure Environment Variables

Before building, create `frontend/.env.production`:

```
VITE_API_URL=https://www.kamransports.pk/api
```

Rebuild:
```bash
npm run build
```

### 3.3 Upload Frontend Files

Using FTP:

1. Upload all files from `frontend/dist/` to `public_html/`
2. Your structure should look like:
   ```
   public_html/
   ├── index.html
   ├── assets/
   ├── api/
   └── uploads/
   ```

## Step 4: Configure URL Rewriting

### 4.1 Root .htaccess Configuration

Create/edit `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Don't rewrite API requests
    RewriteRule ^api/ - [L]
    
    # Don't rewrite uploaded files
    RewriteRule ^uploads/ - [L]
    
    # Route all other requests to index.html (for React Router)
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /index.html [L]
</IfModule>

# Enable gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
</IfModule>
```

## Step 5: Domain Configuration

### 5.1 Point Domain to Hostinger

1. Log in to your domain registrar
2. Update nameservers to Hostinger's:
   ```
   ns1.dns-parking.com
   ns2.dns-parking.com
   ```
3. Or update A record to point to Hostinger's IP

### 5.2 SSL Certificate

1. In hPanel, go to **Security** → **SSL**
2. Enable **Free SSL** for your domain
3. Wait for SSL to activate (usually 5-15 minutes)

## Step 6: Testing

### 6.1 Test API Endpoints

```bash
# Test API connection
curl https://www.kamransports.pk/api/health

# Test products endpoint
curl https://www.kamransports.pk/api/products
```

### 6.2 Test Frontend

1. Visit `https://www.kamransports.pk`
2. Check that pages load correctly
3. Test product browsing
4. Test cart functionality

## Step 7: Post-Deployment Setup

### 7.1 Change Default Admin Password

1. Visit `https://www.kamransports.pk/admin`
2. Login with:
   - Email: admin@kamransports.pk
   - Password: admin123
3. **Immediately change the password!**

### 7.2 Configure Settings

1. Update site settings (contact info, etc.)
2. Add stores/locations
3. Upload product catalog
4. Configure payment gateways

## Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
- Check PHP error logs in hPanel
- Verify database credentials in `config.php`
- Ensure file permissions are correct (644 for files, 755 for directories)

### Issue: API requests fail with CORS error

**Solution:**
- Check `.htaccess` in `public_html/api/`
- Ensure CORS headers are set
- Contact Hostinger support to enable `mod_headers`

### Issue: Images not uploading

**Solution:**
- Check `uploads/` folder permissions (should be 755)
- Verify PHP `upload_max_filesize` and `post_max_size` settings
- Contact Hostinger to increase limits if needed

### Issue: React routes show 404

**Solution:**
- Verify `.htaccess` in `public_html/` is correct
- Check that `mod_rewrite` is enabled (it is by default on Hostinger)

## Maintenance

### Updating the Application

1. **Frontend updates:**
   ```bash
   cd frontend
   npm run build
   # Upload dist/ contents via FTP
   ```

2. **Backend updates:**
   - Upload changed PHP files via FTP
   - Run any new SQL migrations via phpMyAdmin

### Backups

1. **Database:** Use phpMyAdmin to export regularly
2. **Files:** Download via FTP or use Hostinger's backup feature
3. **Automate:** Set up scheduled backups in hPanel

### Monitoring

1. Check PHP error logs regularly in hPanel
2. Monitor disk space usage
3. Review database size
4. Check SSL certificate expiry

## Security Checklist

- [ ] Changed default admin password
- [ ] Database credentials are secure
- [ ] JWT_SECRET is long and random
- [ ] File upload validation is working
- [ ] HTTPS is enforced
- [ ] Regular backups are scheduled
- [ ] Error reporting is disabled in production (display_errors = Off)
- [ ] Sensitive files (.env, config.php) are not web-accessible

## Support

- **Hostinger Support:** https://www.hostinger.com/help
- **Project Issues:** Contact your developer

---

**Next Steps:** Proceed to the Admin Panel to configure your store!
