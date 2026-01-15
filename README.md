# 🛒 Laravel E-Commerce Platform

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**A comprehensive, feature-rich e-commerce platform built with Laravel 12**

[🚀 Live Demo](#) • [📖 Documentation](#installation) • [🐛 Report Bug](#) • [💡 Request Feature](#)

</div>

---

## 📋 Table of Contents

- [✨ Features](#-features)
- [🛠️ Tech Stack](#️-tech-stack)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [🎯 Usage](#-usage)
- [🏗️ Project Structure](#️-project-structure)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

---

## ✨ Features

### 🛍️ **Customer Features**
- **Product Catalog** - Browse products by categories, brands, and filters
- **Advanced Search** - Search products with multiple filters and sorting
- **Shopping Cart** - Add/remove items with variant support (size, color)
- **Wishlist** - Save favorite products for later
- **User Authentication** - Register, login, password reset with email verification
- **Order Management** - Track orders, view history, cancel/return orders
- **Product Reviews** - Rate and review purchased products
- **Multiple Payment Methods** - PayPal, Stripe, Cash on Delivery
- **Responsive Design** - Mobile-first, fully responsive interface

### 👨‍💼 **Admin Features**
- **Dashboard** - Comprehensive analytics and statistics
- **Product Management** - CRUD operations with image gallery, variants
- **Category Management** - Hierarchical categories and subcategories
- **Order Management** - Process orders, update status, manage refunds
- **User Management** - Customer accounts, admin roles
- **Content Management** - Blog system, sliders, partners, FAQs
- **Settings** - Site configuration, payment gateways, shipping methods
- **Notifications** - Real-time admin notifications
- **Reports** - Sales reports, export functionality

### 🔧 **Technical Features**
- **🎛️ FULLY DYNAMIC ADMIN CONTROL** - **Complete frontend control through admin panel - every content, button, image, slider, category, product, and setting is dynamically managed from the admin dashboard**
- **Multi-Image Support** - External URLs (Unsplash) and local storage
- **Dynamic Settings** - Database-driven configuration with fallbacks
- **Email System** - Order confirmations, notifications, password resets
- **SEO Optimized** - Meta tags, friendly URLs, sitemap
- **Security** - CSRF protection, input validation, secure authentication
- **Performance** - Optimized queries, caching, image optimization
- **Localization Ready** - Multi-language support structure

---

## 🛠️ Tech Stack

### **Backend**
<div align="left">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" height="40" alt="Laravel" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" height="40" alt="PHP" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" height="40" alt="MySQL" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/composer/composer-original.svg" height="40" alt="Composer" />
</div>

- **Framework**: Laravel 12.0
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum
- **File Storage**: Local & Cloud Storage
- **Queue System**: Database/Redis
- **Cache**: File/Redis/Memcached

### **Frontend**
<div align="left">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" height="40" alt="HTML5" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" height="40" alt="CSS3" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" height="40" alt="JavaScript" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" height="40" alt="Bootstrap" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" height="40" alt="jQuery" />
</div>

- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5
- **JavaScript**: ES6+, jQuery
- **Build Tool**: Vite
- **Icons**: Font Awesome
- **Maps**: Google Maps API

### **Third-Party Integrations**
- **Payment Gateways**: PayPal, Stripe
- **Email Service**: SMTP, Mailgun, SES
- **Image Processing**: Intervention Image
- **PDF Generation**: DomPDF
- **Excel Export**: Maatwebsite Excel
- **Security**: Cloudflare Turnstile

---

## 📦 Installation

### **Prerequisites**
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+
- Web server (Apache/Nginx)

### **Step 1: Clone Repository**
```bash
git clone https://github.com/your-username/laravel-ecommerce.git
cd laravel-ecommerce
```

### **Step 2: Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **Step 3: Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Database Configuration**
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### **Step 5: Database Migration & Seeding**
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### **Step 6: Storage Setup**
```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### **Step 7: Build Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

### **Step 8: Start Development Server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

---

## ⚙️ Configuration

### **Admin Access**
- **URL**: `/admin/login`
- **Email**: `admin@example.com`
- **Password**: `password`

### **Payment Gateway Setup**

#### **PayPal Configuration**
```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_sandbox_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_sandbox_client_secret
```

#### **Stripe Configuration**
```env
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

### **Email Configuration**
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

### **Google Maps Setup**
```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

---

## 🎯 Usage

### **Customer Journey**
1. **Browse Products** - Explore categories and search products
2. **Add to Cart** - Select variants and add items to cart
3. **Checkout** - Enter shipping details and select payment method
4. **Order Tracking** - Monitor order status and delivery
5. **Reviews** - Rate and review purchased products

### **Admin Workflow**
1. **Dashboard** - Monitor sales, orders, and analytics
2. **Product Management** - Add/edit products with images and variants
3. **Order Processing** - Update order status and handle refunds
4. **Content Management** - Manage blog posts, sliders, and site content
5. **Settings** - Configure payment methods, shipping, and site settings

---

## 🏗️ Project Structure

```
ecommerce/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin panel controllers
│   │   └── Frontend/        # Customer-facing controllers
│   ├── Models/              # Eloquent models
│   ├── Mail/                # Email templates
│   ├── Helpers/             # Helper classes
│   └── Services/            # Business logic services
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   └── views/
│       ├── admin/           # Admin panel views
│       ├── frontend/        # Customer views
│       └── emails/          # Email templates
├── public/
│   ├── frontend/assets/     # Frontend assets
│   └── assets/              # Admin assets
└── routes/
    └── web.php              # Application routes
```

---

## 🚀 Key Features Breakdown

### **🎛️ Complete Admin Control System**
- **100% Dynamic Frontend** - Every element on the website is controlled through admin panel
- **Content Management** - All text, images, buttons, and links managed from admin
- **Visual Control** - Sliders, banners, categories, and product displays fully customizable
- **Settings Management** - Site configuration, contact info, social links, payment methods
- **Real-time Updates** - Changes reflect immediately on frontend without code deployment

### **Product Management**
- Multi-image gallery with external URL support
- Product variants (size, color) with additional pricing
- Stock management and inventory tracking
- SEO-friendly URLs and meta tags

### **Order System**
- Complete order lifecycle management
- Multiple payment gateway integration
- Order status tracking and notifications
- Return and refund processing

### **User Experience**
- Responsive design for all devices
- Advanced product filtering and search
- Wishlist and comparison features
- Guest checkout option

### **Admin Panel**
- Comprehensive dashboard with analytics
- Real-time notifications system
- Bulk operations and data export
- Role-based access control

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com) - The PHP framework for web artisans
- [Bootstrap](https://getbootstrap.com) - Frontend component library
- [Font Awesome](https://fontawesome.com) - Icon library
- [Unsplash](https://unsplash.com) - High-quality images for demo content

---

<div align="center">

**Made with ❤️ using Laravel**

[⬆ Back to Top](#-laravel-e-commerce-platform)

</div>