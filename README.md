# Fast Express Shipping

A professional shipment tracking website built with **Laravel 11**, **Tailwind CSS v3**, and **Alpine.js**.

## Features

- 📦 **Public Tracking Page** — Track any shipment by entering a tracking number
- 🛡️ **Admin Dashboard** — Full CRUD for shipments and tracking events
- 📧 **Email Notifications** — Automatic emails on status changes and new events
- 📱 **SMS Notifications** — Termii SMS alerts (primary), Twilio (fallback)
- 🔔 **Deduplication** — Prevents duplicate notification sends
- 📝 **Notification Log** — Full audit trail of all sent/failed/skipped notifications
- 🚦 **Rate Limiting** — Public tracking endpoint is rate-limited
- 🚀 **GitHub Actions FTP Deploy** — Auto-deploy on push to `main`

## Requirements

- PHP 8.2+
- Composer
- Node.js 20+
- MySQL / PostgreSQL

## Setup

### 1. Clone and install

```bash
git clone https://github.com/mykael2000/fastexpressshipping.git
cd fastexpressshipping
composer install
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fastexpressshipping
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=noreply@fastexpressshipping.com
MAIL_FROM_NAME="Fast Express Shipping"

TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=+15550000000

QUEUE_CONNECTION=database

ADMIN_EMAIL=admin@fastexpressshipping.com
ADMIN_PASSWORD=change-me-now
```

### SMS Providers

The app uses **Termii** as the primary SMS provider with **Twilio** as a fallback.

```env
# Primary SMS provider (default: termii)
SMS_PROVIDER=termii
SMS_FALLBACK_PROVIDER=twilio

# Termii credentials (https://termii.com)
TERMII_API_KEY=your-termii-api-key
TERMII_SENDER_ID=YourSenderID
TERMII_BASE_URL=https://api.ng.termii.com

# Twilio fallback credentials (https://twilio.com)
TWILIO_SID=your-twilio-sid
TWILIO_TOKEN=your-twilio-token
TWILIO_FROM=+15550000000
```

**Fallback behaviour:** If the primary provider throws an exception (e.g. Termii is unreachable), the `SmsManager` automatically retries with the fallback provider. The `NotificationLog` entry records which provider was ultimately used (e.g. `SMS sent successfully via termii.`).

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Create admin user

```bash
php artisan db:seed --class=AdminUserSeeder
```

Or set `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` before running the seeder.

### 5. Build assets

```bash
npm run build
```

### 6. Start queue worker

```bash
php artisan queue:work
```

### 7. Run the application

```bash
php artisan serve
```

Visit http://localhost:8000

## URLs

| URL | Description |
|-----|-------------|
| `/` | Public tracking page |
| `/track/{number}` | Direct tracking result |
| `/admin` | Admin dashboard |
| `/admin/shipments` | Shipment management |
| `/login` | Admin login |

## Deployment (GitHub Actions FTP)

Add these GitHub Secrets in your repository settings:

| Secret | Description |
|--------|-------------|
| `FTP_SERVER` | FTP hostname |
| `FTP_USERNAME` | FTP username |
| `FTP_PASSWORD` | FTP password |
| `FTP_PORT` | FTP port (default: 21) |
| `FTP_REMOTE_DIR` | Remote directory (set to `/`) |

The workflow will:
1. Install PHP dependencies (no dev)
2. Build Tailwind assets
3. Deploy all files via FTP

## Running Tests

```bash
php artisan test
```

## Security

- CSRF protection on all forms
- Input validation on all endpoints
- Output escaping via Blade
- Rate limiting on public tracking
- Secrets managed via `.env` (not committed)
