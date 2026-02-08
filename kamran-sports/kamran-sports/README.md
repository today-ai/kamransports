# Kamran Sports - Multi-Store Retail & eCommerce Platform

A comprehensive retail management system for sports accessories with multi-location inventory, online store, and POS capabilities.

## 🚀 Quick Start

### Prerequisites
- Node.js 18+ and npm
- PHP 8.0+
- MySQL 5.7+
- Hostinger Business Shared Hosting account

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd kamran-sports
```

2. Install frontend dependencies:
```bash
cd frontend
npm install
```

3. Configure backend:
```bash
cd ../backend
cp config.example.php config.php
# Edit config.php with your database credentials
```

4. Import database:
```bash
# Import database/schema.sql into your MySQL database
```

5. Start development:
```bash
# Frontend (in frontend directory)
npm run dev

# Backend - use PHP built-in server or configure with your local Apache/Nginx
php -S localhost:8000 -t public
```

## 📁 Project Structure

```
kamran-sports/
├── frontend/          # React + TypeScript + Vite
├── backend/           # PHP API
├── database/          # MySQL schema and migrations
├── docs/              # Documentation
└── README.md
```

## 🛠️ Tech Stack

- **Frontend:** React 18, TypeScript, Vite, Tailwind CSS, shadcn/ui
- **Backend:** PHP 8+, MySQL
- **Hosting:** Hostinger Business Shared Hosting
- **Authentication:** JWT-based
- **Payment:** Stripe / JazzCash / EasyPaisa

## 📦 Deployment

See [DEPLOYMENT.md](docs/DEPLOYMENT.md) for detailed deployment instructions to Hostinger.

## 📄 License

Proprietary - Kamran Sports © 2026
