# BlogHub — Blogging Platform with Admin Panel

A complete blogging platform built with **Laravel 11** for the **Rhombix Technologies Web Development Internship — Task 1**.

## 🚀 Features

### User Side
- 📖 Read blog posts
- 🔍 Search posts by title/content
- 🏷️ Filter by categories and tags
- 💬 Comment on posts (requires login)
- 👤 User profile with edit settings
- 🔐 Register / Login

### Admin Panel
- 📊 Dashboard with stats
- ✍️ Create/Edit/Delete posts with Rich Text Editor (TinyMCE/CKEditor)
- 🖼️ Featured image upload + inline editor image upload
- 📂 Manage categories
- 🏷️ Manage tags
- 💬 Approve/Delete comments
- 👥 Manage users (change roles, delete)

### Authentication & Roles
- Laravel Breeze (Blade)
- Spatie Laravel Permission (Admin / User roles)
- Role-based redirect (Admin → Dashboard, User → Home)

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| Framework | Laravel 11 |
| Language | PHP 8.2 |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS (CDN) |
| Authentication | Laravel Breeze |
| Roles | Spatie Laravel Permission |
| Rich Text Editor | TinyMCE / CKEditor 5 |

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/RhombixTechnologies_Tasks.git

# Navigate to project
cd RhombixTechnologies_Tasks

# Install dependencies
composer install
npm install

# Copy .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env
# DB_DATABASE=blogging_platform
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Build assets
npm run build

# Start server
php artisan serve