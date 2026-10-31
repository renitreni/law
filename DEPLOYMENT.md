# Law Practice Management - Deployment Guide

## Overview
This document describes the complete deployment process for the Law Practice Management application (Laravel 10) to the server `root@187.127.100.178` as a subdomain of `yaramay.online`.

## Server Specifications
- **OS**: Ubuntu 24.04.4 LTS
- **Docker**: 29.6.0
- **Docker Compose**: v5.1.4
- **Nginx**: Already running on ports 80/443 (serves other sites)
- **MariaDB**: Running on 127.0.0.1:3306 (host, not used by this app)
- **Resources**: 8 GB RAM, 96 GB disk (77 GB free)

## Subdomain
**`law.yaramay.online`**

## Architecture
```
Internet → Nginx (host, :80/:443) → law.yaramay.online → 127.0.0.1:8080 → Docker App Container (:80)
                                                         → Docker MySQL Container (:3306)
                                                         → Docker Redis Container (:6379)
```

## Prerequisites
- SSH access to `root@187.127.100.178`
- Git repository access (`git@github.com:renitreni/law.git`)
- Domain `yaramay.online` pointing to server IP
- Certbot/Let's Encrypt for SSL

---

## Deployment Steps

### 1. Prepare Server Directory
```bash
ssh root@187.127.100.178
mkdir -p /var/www/law
cd /var/www/law
```

### 2. Clone Repository
```bash
git clone git@github.com:renitreni/law.git .
git checkout main
```

### 3. Configure Environment
```bash
cp .env.docker.example .env
# Edit .env with production values:
# - APP_URL=https://law.yaramay.online
# - DB_PASSWORD=secure_random_password
# - DB_ROOT_PASSWORD=secure_random_root_password
# - MAIL_* settings for your SMTP provider
```

**Required .env variables:**
```env
APP_NAME="Law Practice Management"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://law.yaramay.online

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=law
DB_USERNAME=law
DB_PASSWORD=your_secure_password
DB_ROOT_PASSWORD=your_secure_root_password

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yaramay.online"
MAIL_FROM_NAME="Law Practice Management"
```

### 4. Build and Start Containers
```bash
docker compose up -d --build
```

Verify containers are running:
```bash
docker compose ps
# Expected: law_app, law_mysql, law_redis all "Up"
```

### 5. Run Migrations and Seed Data
```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

This creates:
- 5 user accounts (see [Accounts](#5-user-accounts))
- 10 matters with 5 submatters each
- 10 clients, 10 offices
- 800 time entries
- 15 law cases with clients, courts, files
- 10 invoices with services
- Announcements, galleries, inquiries
### 6. Configure Host Nginx Reverse Proxy
Create `/etc/nginx/sites-available/law.yaramay.online`:
```nginx
server {
    listen 80;
    server_name law.yaramay.online;

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_read_timeout 300;
        proxy_connect_timeout 300;
        proxy_send_timeout 300;
    }
}
```

Enable and test:
```bash
ln -s /etc/nginx/sites-available/law.yaramay.online /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

### 7. Obtain SSL Certificate
```bash
certbot --nginx -d law.yaramay.online --email your-admin@yaramay.online --agree-tos --no-eff-email
```

Verify auto-renewal:
```bash
systemctl status certbot.timer
# or
crontab -l
```

### 8. Verify Deployment
```bash
# Check HTTPS
curl -I https://law.yaramay.online

# Check migrations
docker compose exec app php artisan migrate:status

# Check logs
docker compose logs -f app
```

---

## 5 User Accounts (Created by Seeder)

| # | Name | Email | Password | Role |
|---|------|-------|----------|------|
| 1 | Admin User | admin@yaramay.online | `Admin_2026!` | Administrator |
| 2 | Maha Aljubaire | atty.mahaaljubaire@yaramay.online | `Atty_maha_2026!` | Attorney |
| 3 | Info Desk | info@yaramay.online | `Info_2026!` | Staff |
| 4 | John Attorney | john.attorney@yaramay.online | `John_2026!` | Attorney |
| 5 | Sarah Clerk | sarah.clerk@yaramay.online | `Sarah_2026!` | Clerk |

**⚠️ Change passwords on first login!**

---

## Ongoing Operations

### Code Updates
```bash
cd /var/www/law
git pull origin main
docker compose up -d --build
docker compose exec app php artisan migrate --force
```

### View Logs
```bash
docker compose logs -f app
docker compose logs -f mysql
docker compose logs -f redis
```

### Database Backup
```bash
# Backup
docker compose exec mysql mysqldump -u root -p$DB_ROOT_PASSWORD law > backup_$(date +%F).sql

# Restore
docker compose exec -T mysql mysql -u root -p$DB_ROOT_PASSWORD law < backup_2024-01-15.sql
```

### Volume Backup (MySQL Data)
```bash
docker run --rm -v law_law_mysql_data:/data -v $(pwd):/backup alpine tar czf /backup/mysql_data_$(date +%F).tar.gz -C /data .
```

### Rollback
```bash
# Git rollback
git revert HEAD
git push origin main

# Or checkout previous tag
git checkout v1.0.0
docker compose up -d --build
```

---

## Troubleshooting

### App Container Won't Start
```bash
docker compose logs app
# Check for: missing APP_KEY, permission issues, migration failures
```

### Database Connection Failed
```bash
docker compose exec mysql mysqladmin ping -h localhost
# Verify DB_PASSWORD matches .env
```

### Nginx 502 Bad Gateway
```bash
# Check app container is up
docker compose ps
# Check port mapping
docker compose port app 80
# Should show 127.0.0.1:8080
```

### SSL Certificate Issues
```bash
certbot renew --dry-run
certbot certificates
```

### Permission Errors
```bash
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

---

## File Structure (Docker-related)
```
law/
├── .dockerignore
├── Dockerfile
├── docker-entrypoint.sh
├── docker-compose.yml
├── nginx/
│   └── app.conf
├── .env.docker.example
└── DEPLOYMENT.md
```

---

## Security Checklist
- [ ] Strong DB passwords in `.env`
- [ ] `APP_DEBUG=false`
- [ ] HTTPS enforced via Certbot
- [ ] `.env` not in git (in `.gitignore`)
- [ ] Regular DB backups
- [ ] Monitor `docker compose logs` for errors
- [ ] Keep Docker images updated (`docker compose pull && docker compose up -d`)

---

## Support Contacts
- **Repository**: git@github.com:renitreni/law.git
- **Server**: root@187.127.100.178
- **Domain**: law.yaramay.online
