# Kamran Sports - Quick Start Guide

## ⚡ Get Up and Running in 10 Minutes

### Step 1: Prerequisites Check ✓

Make sure you have installed:
- [ ] Node.js 18+ (`node --version`)
- [ ] PHP 8.0+ (`php --version`)
- [ ] MySQL 5.7+ or XAMPP/MAMP
- [ ] Git (`git --version`)

### Step 2: Database Setup (3 minutes)

```bash
# Start MySQL (if using XAMPP, start from control panel)

# Create database
mysql -u root -p
# Enter password (leave blank if no password)
```

```sql
CREATE DATABASE kamran_sports CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

```bash
# Import schema
mysql -u root -p kamran_sports < database/schema.sql
```

### Step 3: Backend Configuration (2 minutes)

```bash
cd backend
cp config.example.php config.php
```

Edit `config.php` - **only change these lines:**

```php
define('DB_USER', 'root');        // Your MySQL username
define('DB_PASS', '');            // Your MySQL password (if any)
define('JWT_SECRET', 'my-super-secret-key-change-in-production');
```

### Step 4: Start Backend (1 minute)

```bash
cd backend/public
php -S localhost:8000
```

**Test:** Open http://localhost:8000/health in your browser
- Should see: `{"success":true,"message":"Kamran Sports API is running"...}`

### Step 5: Frontend Setup (3 minutes)

**Open a NEW terminal window** (keep backend running)

```bash
cd frontend
npm install
```

Create `.env.local` file:
```
VITE_API_URL=http://localhost:8000
```

```bash
npm run dev
```

### Step 6: Access Your Site ✨

**Frontend:** http://localhost:3000
**Backend API:** http://localhost:8000
**Admin Login:** 
- Email: `admin@kamransports.pk`
- Password: `admin123` (change this!)

---

## 🎯 What's Working Now?

✅ Database with all tables created
✅ Backend API server running
✅ Frontend development server
✅ API endpoint: `/products` (currently empty)
✅ API endpoint: `/categories` (currently empty)
✅ API endpoint: `/health` (for testing)

## 📝 What to Do Next?

### Add Sample Data

```sql
# Connect to MySQL
mysql -u root -p kamran_sports

# Add a category
INSERT INTO categories (name, slug, description, is_active) 
VALUES ('Sports Balls', 'sports-balls', 'All types of sports balls', 1);

# Add a brand
INSERT INTO brands (name, slug, is_active) 
VALUES ('Nike', 'nike', 1);

# Add a product
INSERT INTO products (name, slug, sku, category_id, brand_id, base_price, description, is_active) 
VALUES (
  'Professional Basketball',
  'professional-basketball',
  'BB-001',
  1,
  1,
  4500.00,
  'High-quality basketball for professional and recreational play',
  1
);
```

### Test the API

```bash
# Get products (should now show the basketball)
curl http://localhost:8000/products

# Get categories
curl http://localhost:8000/categories
```

---

## 🐛 Troubleshooting

### Backend won't start?

**Error:** `Address already in use`
- **Solution:** Port 8000 is busy. Use: `php -S localhost:8080` instead
- Update frontend `.env.local` to: `VITE_API_URL=http://localhost:8080`

**Error:** `Database connection failed`
- **Solution:** Check MySQL is running
- Verify username/password in `config.php`

### Frontend shows blank page?

- Check browser console for errors (F12)
- Make sure backend is running on port 8000
- Verify `.env.local` exists with correct API URL

### Can't import database schema?

- **Solution:** Make sure you're in the project root folder
- Full path: `mysql -u root -p kamran_sports < /full/path/to/database/schema.sql`

---

## 🚀 Next Steps

1. **Read the full docs:**
   - `docs/DEVELOPMENT.md` - Complete development guide
   - `docs/DEPLOYMENT.md` - How to deploy to Hostinger

2. **Start building features:**
   - Implement authentication
   - Create product pages
   - Build shopping cart
   - Add checkout process

3. **Customize:**
   - Update branding colors in `tailwind.config.js`
   - Add your logo
   - Customize homepage

---

## 📞 Need Help?

Check these files:
- `README.md` - Project overview
- `docs/DEVELOPMENT.md` - Detailed development guide
- `docs/DEPLOYMENT.md` - Deployment instructions

---

**You're all set! Happy coding! 🎉**
