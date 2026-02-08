# Kamran Sports - Development Guide

## 🚀 Getting Started

### Prerequisites

Before you begin, ensure you have:
- **Node.js 18+** and npm installed ([Download here](https://nodejs.org/))
- **PHP 8.0+** installed ([Download here](https://www.php.net/downloads))
- **MySQL 5.7+** or **MariaDB 10.3+** ([Download MySQL](https://dev.mysql.com/downloads/) or [XAMPP](https://www.apachefriends.org/))
- **Git** for version control ([Download here](https://git-scm.com/))
- A code editor (recommended: [VS Code](https://code.visualstudio.com/))

### Local Development Setup

#### Step 1: Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/kamran-sports.git
cd kamran-sports
```

#### Step 2: Database Setup

1. **Create MySQL Database:**

```bash
# Using MySQL command line
mysql -u root -p
```

```sql
CREATE DATABASE kamran_sports CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

2. **Import Schema:**

```bash
mysql -u root -p kamran_sports < database/schema.sql
```

This creates all tables and inserts initial data including a default admin user.

**Default Admin Credentials:**
- Email: `admin@kamransports.pk`
- Password: `admin123` (**CHANGE THIS IMMEDIATELY!**)

#### Step 3: Backend Configuration

```bash
cd backend
cp config.example.php config.php
```

Edit `config.php` with your local settings:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'kamran_sports');
define('DB_USER', 'root');  // your MySQL username
define('DB_PASS', '');      // your MySQL password
define('JWT_SECRET', 'your-long-random-string-here');
define('APP_URL', 'http://localhost:3000');
define('API_URL', 'http://localhost:8000');
```

**Generate a secure JWT_SECRET:**
```bash
# On Linux/Mac
openssl rand -base64 32

# On Windows PowerShell
[Convert]::ToBase64String((1..32|%{Get-Random -Max 256}))
```

#### Step 4: Start Backend Server

```bash
cd backend/public
php -S localhost:8000
```

Test the API:
```bash
curl http://localhost:8000/health
```

You should see:
```json
{
  "success": true,
  "message": "Kamran Sports API is running",
  "version": "1.0.0"
}
```

#### Step 5: Frontend Setup

Open a **new terminal window**:

```bash
cd frontend
npm install
```

Create `.env.local`:
```
VITE_API_URL=http://localhost:8000
```

Start the development server:
```bash
npm run dev
```

Visit: `http://localhost:3000`

---

## 📁 Project Structure

```
kamran-sports/
├── backend/                    # PHP Backend
│   ├── config.example.php      # Configuration template
│   ├── public/
│   │   └── index.php          # Main entry point
│   ├── src/
│   │   ├── controllers/       # Request handlers
│   │   │   ├── ProductController.php
│   │   │   ├── AuthController.php
│   │   │   └── OrderController.php
│   │   ├── models/            # Database models (to be created)
│   │   ├── middleware/        # Auth, CORS, etc. (to be created)
│   │   ├── routes/
│   │   │   └── api.php        # Route definitions
│   │   └── utils/
│   │       ├── Database.php   # Database connection
│   │       └── Router.php     # Routing system
│   └── uploads/               # File uploads
│
├── frontend/                   # React Frontend
│   ├── src/
│   │   ├── components/        # Reusable UI components
│   │   ├── pages/             # Page components
│   │   ├── hooks/             # Custom React hooks
│   │   ├── services/          # API services
│   │   ├── stores/            # State management (Zustand)
│   │   ├── types/             # TypeScript types
│   │   └── lib/               # Utility functions
│   ├── public/                # Static assets
│   └── package.json
│
├── database/
│   └── schema.sql             # Complete database schema
│
└── docs/
    └── DEPLOYMENT.md          # Hostinger deployment guide
```

---

## 🔧 Development Workflow

### Creating New Features

#### 1. Backend: Adding a New API Endpoint

**Example: Get Store Locations**

1. **Create Controller Method** (`backend/src/controllers/StoreController.php`):

```php
<?php

class StoreController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index($params = []) {
        $sql = "SELECT * FROM stores WHERE status = 'active' ORDER BY name";
        $stores = $this->db->fetchAll($sql);
        
        echo json_encode([
            'success' => true,
            'data' => $stores
        ]);
    }
}
```

2. **Register Route** (in `backend/src/routes/api.php`):

```php
require_once __DIR__ . '/../controllers/StoreController.php';

// Add to registerRoutes function:
$router->get('/stores', ['StoreController', 'index']);
```

3. **Test**:
```bash
curl http://localhost:8000/stores
```

#### 2. Frontend: Creating a New Component

**Example: Store Locator Component**

```bash
cd frontend/src/components
```

Create `StoreLocator.tsx`:

```typescript
import { useEffect, useState } from 'react';
import axios from 'axios';

interface Store {
  id: number;
  name: string;
  address: string;
  city: string;
  phone: string;
}

export default function StoreLocator() {
  const [stores, setStores] = useState<Store[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get(`${import.meta.env.VITE_API_URL}/stores`)
      .then(res => {
        setStores(res.data.data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Loading...</div>;

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      {stores.map(store => (
        <div key={store.id} className="border p-4 rounded-lg">
          <h3 className="font-bold text-lg">{store.name}</h3>
          <p className="text-sm text-gray-600">{store.address}</p>
          <p className="text-sm text-gray-600">{store.city}</p>
          <p className="text-sm font-medium mt-2">{store.phone}</p>
        </div>
      ))}
    </div>
  );
}
```

Use it in a page:

```typescript
import StoreLocator from '@/components/StoreLocator';

export default function StoresPage() {
  return (
    <div className="container mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold mb-6">Our Stores</h1>
      <StoreLocator />
    </div>
  );
}
```

---

## 🎨 Frontend Development

### Using shadcn/ui Components

shadcn/ui provides pre-built, accessible components. To add components:

```bash
# Button component
npx shadcn-ui@latest add button

# Card component
npx shadcn-ui@latest add card

# Form components
npx shadcn-ui@latest add input
npx shadcn-ui@latest add label
npx shadcn-ui@latest add form
```

Usage:

```typescript
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

<Card>
  <CardHeader>
    <CardTitle>Product Title</CardTitle>
  </CardHeader>
  <CardContent>
    <p>Product description here</p>
    <Button>Add to Cart</Button>
  </CardContent>
</Card>
```

### API Integration with React Query

```typescript
// src/services/productService.ts
import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL;

export const productService = {
  getAll: async (params?: any) => {
    const { data } = await axios.get(`${API_URL}/products`, { params });
    return data;
  },
  
  getBySlug: async (slug: string) => {
    const { data } = await axios.get(`${API_URL}/products/${slug}`);
    return data;
  }
};

// In component:
import { useQuery } from '@tanstack/react-query';
import { productService } from '@/services/productService';

function ProductList() {
  const { data, isLoading } = useQuery({
    queryKey: ['products'],
    queryFn: () => productService.getAll()
  });

  if (isLoading) return <div>Loading...</div>;

  return (
    <div>
      {data.data.map(product => (
        <div key={product.id}>{product.name}</div>
      ))}
    </div>
  );
}
```

---

## 🔐 Authentication (Next Steps)

### 1. Implement JWT Authentication

**Backend** (`backend/src/utils/JWT.php`):

```php
<?php
class JWT {
    public static function encode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);
        
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = self::base64UrlEncode($signature);
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decode($jwt) {
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) != 3) return false;
        
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];
        
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = self::base64UrlEncode($signature);
        
        if ($base64UrlSignature === $signatureProvided) {
            return json_decode($payload, true);
        }
        
        return false;
    }

    private static function base64UrlEncode($text) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}
```

### 2. Authentication Middleware

Create `backend/src/middleware/AuthMiddleware.php`:

```php
<?php
class AuthMiddleware {
    public static function authenticate() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        
        if (!$authHeader || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }
        
        $token = $matches[1];
        $payload = JWT::decode($token);
        
        if (!$payload) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid token']);
            exit();
        }
        
        return $payload;
    }
}
```

---

## 📊 Database Operations

### Adding Sample Data

```sql
-- Add categories
INSERT INTO categories (name, slug, description) VALUES
('Indoor Sports', 'indoor-sports', 'Equipment for indoor sports'),
('Outdoor Sports', 'outdoor-sports', 'Equipment for outdoor sports'),
('Balls', 'balls', 'Sports balls for all games');

-- Add brands
INSERT INTO brands (name, slug) VALUES
('Nike', 'nike'),
('Adidas', 'adidas'),
('Wilson', 'wilson');

-- Add a product
INSERT INTO products (name, slug, sku, category_id, brand_id, base_price, description) VALUES
('Professional Basketball', 'professional-basketball', 'BB-001', 3, 1, 4500.00, 'Official size basketball for professional play');
```

---

## 🧪 Testing

### Backend API Testing with cURL

```bash
# Get all products
curl http://localhost:8000/products

# Get product by slug
curl http://localhost:8000/products/professional-basketball

# Get categories
curl http://localhost:8000/categories
```

### Frontend Testing

```bash
cd frontend
npm run lint          # Check for code issues
npm run build         # Test production build
npm run preview       # Preview production build
```

---

## 📦 Building for Production

### Frontend Build

```bash
cd frontend
npm run build
```

Output will be in `frontend/dist/`

### Backend Preparation

No build step needed. Just ensure:
1. `config.php` has production credentials
2. Error reporting is off in production
3. All sensitive files are secured

---

## 🐛 Common Issues & Solutions

### Issue: Database connection failed

**Solution:**
- Check MySQL is running
- Verify credentials in `config.php`
- Ensure database exists

### Issue: CORS errors in frontend

**Solution:**
- Check API_URL in frontend `.env.local`
- Verify CORS headers in `backend/public/index.php`
- Add your frontend URL to `CORS_ALLOWED_ORIGINS`

### Issue: 404 on API routes

**Solution:**
- Ensure PHP server is running on port 8000
- Check route is registered in `api.php`
- Verify controller file exists

---

## 📝 Next Steps for Development

### Phase 1 - Foundation (Current Priority)

- [ ] Complete page components in frontend
- [ ] Implement authentication (login/register)
- [ ] Add basic product display
- [ ] Create shopping cart functionality

### Phase 2 - Core Features

- [ ] Checkout process
- [ ] Order management
- [ ] Admin panel
- [ ] Inventory management

### Phase 3 - Advanced Features

- [ ] POS system
- [ ] Multi-store inventory
- [ ] Payment gateway integration
- [ ] Email notifications

---

## 🤝 Contributing

When making changes:

1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Commit with clear messages
5. Push to GitHub

---

## 📚 Resources

- [React Documentation](https://react.dev/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [PHP Manual](https://www.php.net/manual/en/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

**Ready to start building? Let's go! 🚀**
