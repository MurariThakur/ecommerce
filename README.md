<div align="center">

# 🛍️ Laravel E-Commerce Platform

<img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12.0" />
<img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
<img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.0+" />
<img src="https://img.shields.io/badge/Bootstrap-5.0-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.0" />
<img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript ES6+" />

### 🚀 A Modern, Feature-Rich E-Commerce Platform

**Built with Laravel 12 | Fully Dynamic Admin Control | Production-Ready**

[📖 Quick Start](#-installation) &nbsp; • &nbsp; [✨ Features](#-features) &nbsp; • &nbsp; [📁 Structure](#️-project-structure) &nbsp; • &nbsp; [🤝 Contributing](#-contributing)

</div>

---

## � Quick Navigation

| Section | Description |
|---------|-------------|
| [✨ Features](#-features) | Customer & Admin Features |
| [🛠️ Tech Stack](#️-tech-stack) | Technology Overview |
| [📦 Installation](#-installation) | Setup Instructions |
| [⚙️ Configuration](#️-configuration) | Configuration Guide |
| [🎯 Usage](#-usage) | How to Use |
| [🏗️ Structure](#️-project-structure) | Project Organization |

---

## ✨ Features

> **🎛️ Complete Dynamic Control** - Every aspect of the storefront is managed through the admin panel

### 🛍️ Customer Portal

| Feature | Details |
|---------|---------|
| 🏪 **Product Catalog** | Browse products by categories, brands, and filters |
| 🔍 **Smart Search** | Advanced filtering with sorting capabilities |
| 🛒 **Smart Cart** | Add/remove items with variant support (size, color) |
| ❤️ **Wishlist** | Save favorite products for later |
| 👤 **User Auth** | Register, login, password reset with email verification |
| 📦 **Order Tracking** | Real-time order status and history |
| ⭐ **Reviews** | Rate and review purchased products |
| 💳 **Payment Options** | PayPal, Stripe, Cash on Delivery |
| 📱 **Responsive** | Mobile-optimized interface |

### 👨‍💼 Admin Dashboard

| Feature | Details |
|---------|---------|
| 📊 **Analytics** | Real-time sales data & statistics |
| 📦 **Products** | CRUD with images, variants, pricing |
| 🏷️ **Categories** | Hierarchical categories & subcategories |
| 📋 **Orders** | Status updates, refund management |
| 👥 **Users** | Customer management & roles |
| 📝 **Content** | Blog, sliders, partners, FAQs |
| ⚙️ **Settings** | Payment gateways, shipping methods |
| 🔔 **Notifications** | Real-time admin alerts |
| 📈 **Reports** | Sales data & export functions |

### 🔧 Technical Highlights

- ✅ **100% Dynamic Content** - Complete frontend control through admin panel
- ✅ **Multi-Image Support** - External URLs (Unsplash) & local storage
- ✅ **Email System** - Order confirmations & notifications
- ✅ **SEO Optimized** - Meta tags & friendly URLs
- ✅ **Secure** - CSRF protection & input validation
- ✅ **Fast** - Optimized queries & caching
- ✅ **Scalable** - Queue system & performance tuning

---

## 🛠️ Tech Stack

### Backend Stack
<div align="center">

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Laravel** | 12.0 | PHP Framework |
| **PHP** | 8.2+ | Server Language |
| **MySQL** | 8.0+ | Database |
| **Composer** | Latest | PHP Package Manager |

</div>

<div align="left">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" height="50" alt="Laravel" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" height="50" alt="PHP" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" height="50" alt="MySQL" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/composer/composer-original.svg" height="50" alt="Composer" />
</div>

- **Authentication**: Laravel Sanctum
- **File Storage**: Local & Cloud Storage
- **Queue System**: Database/Redis
- **Cache**: File/Redis/Memcached

### Frontend Stack
<div align="center">

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Bootstrap** | 5.0 | CSS Framework |
| **JavaScript** | ES6+ | Client Language |
| **Vite** | Latest | Build Tool |
| **jQuery** | Latest | DOM Manipulation |

</div>

<div align="left">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" height="50" alt="HTML5" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" height="50" alt="CSS3" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" height="50" alt="JavaScript" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" height="50" alt="Bootstrap" />&nbsp;&nbsp;
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" height="50" alt="jQuery" />
</div>

- **Template Engine**: Blade
- **Build Tool**: Vite
- **Icons**: Font Awesome
- **Maps**: Google Maps API

### Third-Party Integrations
<div align="center">

| Service | Purpose |
|---------|---------|
| **PayPal & Stripe** | Payment Processing |
| **SMTP/Mailgun/SES** | Email Service |
| **Intervention Image** | Image Processing |
| **DomPDF** | PDF Generation |
| **Maatwebsite Excel** | Excel Export |
| **Cloudflare Turnstile** | Security |

</div>

---

## 📦 Installation

### Prerequisites

```
✓ PHP 8.2 or higher
✓ Composer
✓ Node.js & NPM
✓ MySQL 8.0+
✓ Web Server (Apache/Nginx)
```

### Setup Instructions

**Step 1: Clone Repository**
```bash
git clone https://github.com/your-username/laravel-ecommerce.git
cd laravel-ecommerce
```

**Step 2: Install Dependencies**
```bash
composer install && npm install
```

**Step 3: Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

**Step 4: Database Setup**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**Step 5: Run Migrations & Seeding**
```bash
php artisan migrate --seed
php artisan storage:link
```

**Step 6: Build Frontend Assets**
```bash
npm run dev          # Development
npm run build        # Production
```

**Step 7: Start Server**
```bash
php artisan serve
# Visit http://localhost:8000
```

✅ **You're all set! The application is ready to use.**

---

## ⚙️ Configuration

### Admin Access
```
🔗 URL:      /admin/login
📧 Email:    admin@example.com
🔑 Password: password
```

### Payment Gateway Setup

#### PayPal
```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_sandbox_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_sandbox_client_secret
```

#### Stripe
```env
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

### Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="Your Store"
```

### Google Maps API
```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

---

## 🎯 Usage

### Customer Journey
```
1️⃣  Browse Products   → Explore categories and search
2️⃣  Select Variants   → Choose size, color, quantity
3️⃣  Add to Cart       → Review and manage cart
4️⃣  Checkout          → Enter shipping details
5️⃣  Pay Online        → Complete payment
6️⃣  Track Order       → Monitor delivery status
7️⃣  Leave Review      → Rate purchased products
```

### Admin Workflow
```
1️⃣  Dashboard         → View analytics and sales
2️⃣  Manage Products   → Add, edit, delete with images
3️⃣  Process Orders    → Update status and refunds
4️⃣  Manage Content    → Blog, sliders, FAQs
5️⃣  Configure Site    → Payment, shipping, settings
6️⃣  View Reports      → Export data and analytics
```

---

## 🏗️ Project Structure

```
ecommerce/
│
├── 📁 app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           ← Admin dashboard controllers
│   │   │   └── Frontend/        ← Customer-facing controllers
│   │   ├── Middleware/          ← Authentication & authorization
│   │   └── Requests/            ← Form validation classes
│   │
│   ├── Models/                  ← Eloquent models (20+ models)
│   ├── Mail/                    ← Email templates & classes
│   ├── Services/                ← Business logic
│   ├── Helpers/                 ← Utility functions
│   ├── Console/                 ← Artisan commands
│   └── Providers/               ← Service providers
│
├── 📁 database/
│   ├── migrations/              ← Database schema
│   └── seeders/                 ← Sample data
│
├── 📁 resources/
│   ├── views/
│   │   ├── admin/               ← Admin panel views
│   │   ├── frontend/            ← Customer views
│   │   └── emails/              ← Email templates
│   ├── css/                     ← Stylesheets
│   └── js/                      ← JavaScript files
│
├── 📁 routes/
│   ├── web.php                  ← Web routes (admin & frontend)
│   └── console.php              ← Console commands
│
├── 📁 public/
│   ├── assets/                  ← Admin assets
│   ├── frontend/                ← Frontend assets
│   └── storage/                 ← Public uploads
│
├── 📁 config/                   ← Configuration files
├── 📁 tests/                    ← Unit & feature tests
└── 📁 storage/                  ← Logs & cache
```

### Key Models
- **User** - Customer & admin accounts
- **Product** - Product catalog with variants
- **Order** - Order management system
- **Payment** - Payment processing
- **Review** - Customer reviews & ratings
- **Blog** - Blog posts & categories
- **And 14+ more models...**

---

## 🚀 Core Features Breakdown

### 🎛️ Complete Admin Control System
> ✨ **100% Dynamic Frontend** - Every element is controlled through admin panel

- **Content Management** - All text, images, buttons managed from admin
- **Visual Editor** - Sliders, banners, categories fully customizable
- **Settings Hub** - Site config, contact info, social links, payment methods
- **Live Updates** - Changes reflect instantly without code deployment
- **Role Management** - Admin roles & permissions

### 📦 Order Management System

- Complete order lifecycle (pending → delivered)
- Multiple payment gateway integration
- Refund & return processing
- Order status notifications
- Bulk operations

### 🎨 Product Management

- Multi-image gallery support
- Product variants (size, color)
- Stock & inventory tracking
- SEO-friendly URLs
- Dynamic pricing

### 👥 User Management

- Customer profiles & authentication
- Order history & wishlist
- Review & rating system
- Admin role-based access
- Email notifications

---

---

## 📚 Resources & Acknowledgments

| Resource | Purpose |
|----------|---------|
| [Laravel Docs](https://laravel.com) | PHP Framework Documentation |
| [Bootstrap](https://getbootstrap.com) | Frontend Components |
| [Font Awesome](https://fontawesome.com) | Icon Library |
| [Unsplash](https://unsplash.com) | Demo Images |

---

## 📄 License

This project is open-source software licensed under the [MIT license](LICENSE.md).

---

<div align="center">

### 🎉 Thank You for Using Our E-Commerce Platform!

**Questions?** Check the [documentation](#-installation) or open an issue.

**Want to contribute?** We love pull requests! See [CONTRIBUTING.md](CONTRIBUTING.md)

---

<sub>Made with ❤️ by the Developer Community | Powered by Laravel 12</sub>

[⬆ Back to Top](#-laravel-e-commerce-platform)

</div>