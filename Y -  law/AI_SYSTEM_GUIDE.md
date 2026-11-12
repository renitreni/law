# AI System Guide — Global Scan

> Reference document for AI sessions. Attach or paste this file at the start of a session so the
> assistant can skip re-discovering the environment. **Last scanned: 2026-11-12** (Asia/Manila).
> To refresh: ask the assistant to "re-run the global scan and update AI_SYSTEM_GUIDE.md".

---

## 1. Machine & OS

| Item | Value |
|---|---|
| Hostname | `reniertrenuela-GQ0534JLY6.local` |
| OS | macOS 27.2 (build 26B123), Darwin kernel 27.2.0 |
| Arch / CPU | arm64 — Apple M3 Pro, 12 cores |
| RAM | 36 GB |
| Disk | 460 GiB total, ~188 GiB free (7% used) |
| Display | 3456 × 2234 Retina, Metal 4 |
| Timezone | Asia/Manila (UTC+8) |
| Default shell | /bin/bash |
| Xcode | ❌ Full Xcode not installed — Command Line Tools only (`xcodebuild` unavailable) |

## 2. Developer Toolchain

| Tool | Version | Path |
|---|---|---|
| Git | 2.54.0 (Apple Git-157) | /usr/bin/git |
| Node.js | v24.22.1 | Kimi-managed runtime bin (shadows brew node@24) |
| npm / npx | 11.12.1 | same managed path |
| PHP (CLI default) | 8.4.19 (NTS) | /opt/homebrew/bin/php |
| PHP versions via Homebrew | 7.0, 8.2, 8.3, 8.4 (+ phpredis, xdebug, apcu for 8.3) | brew: php@7.0 / php@8.2 / php@8.3 / php@8.4 |
| Python (in-session `python`/`python3`) | 3.12.16 — Kimi managed venv with pandas, numpy, matplotlib, seaborn, pillow, openpyxl, pypdf, reportlab, python-docx, bs4, jinja2, duckdb + CJK fonts | daimon runtime .venv |
| Python via Homebrew | 3.13, 3.14 | brew python@3.13 / python@3.14 |
| Docker | Engine 29.8.2, **daemon running** (36 containers, 59 images) | /usr/local/bin/docker |
| Docker Compose | v5.6.0 | /usr/local/bin/docker-compose |
| Java | OpenJDK 17.0.18 | /usr/bin/java |
| Ruby | 2.6.10 (system) | /usr/bin/ruby |
| Homebrew | 7.0.7 | /opt/homebrew/bin/brew |
| Other brew tools | cocoapods, mkcert, htop, ripgrep, watchman, pipx, uv, vim, mysql@8.0, node@24 | — |
| Not installed | go, rustc/cargo, VS Code CLI (`code`) | — |

PHP CLI extensions (key): pdo_mysql, pdo_pgsql, pgsql, pdo_sqlite, gd, intl, mbstring, soap, ldap, snmp, tidy, bcmath, gmp, zip, OPcache. (No redis/xdebug on default 8.4 CLI.)

## 3. Current Project — `law` (Laravel)

- **Repo root:** `/Users/renier.trenuela/www/law` (the working workspace is the subfolder `Y -  law/`, currently empty; deliverables go there)
- **Git:** `git@github.com:renitreni/law.git`, branch at scan time: `feat-timesheet-menu-routes`, clean tree
- **Stack:**
  - Laravel Framework **10.50.4** (composer requires ^10.10), PHP ^8.1
  - **Inertia.js + React 18** (`@inertiajs/react` ^2.0, inertia-laravel ^2.0)
  - **Livewire ^3.4** (hybrid: Inertia/React pages + Livewire components)
  - Laravel Sanctum ^3.0 (API auth), laravel/ui ^4.2, Tinker, Pint (lint), Sail ^1.0 (dev docker)
  - Frontend deps: flatpickr, keen-slider; build via Vite (`vite.config.js`)
- **Infra files:** `Dockerfile`, `docker-compose.yml`, `docker-entrypoint.sh`, `nginx/`, `phpunit.xml`, `backup_2026-11-01.sqlnn#` (DB backup), docs: DEPLOYMENT.md, DEPLOYMENT_ANALYSIS.md, DEVELOPMENT_PLAN.md
- **Project conventions requested by owner:** Docker-aware (permissions, volumes, container networking); targeted edits only; keep Codacy complexity < 10; preserve error handling, validation, type hints; no new dependencies without asking; sanitize inputs / prevent SQL injection.

## 4. Project Architecture (`law`)

**Domain:** law-firm management system — cases, clients, matters, courts, invoicing, timesheets, inquiries, gallery, announcements.

### Rendering model (hybrid — important!)
- **Inertia.js + React 18** pages under `resources/js/pages/` (`LawCase/{Court,File,Client}`, `Timesheet`, `Case`, `Invoice`, `Matter`, `Inquiry`, `Gallery`, `User`, `Options`), shared `resources/js/Layouts/`, root template `resources/views/app.blade.php`, shared data via `App\Http\Middleware\HandleInertiaRequests`
- **Livewire 3** components under `app/Livewire/` — data tables (`CaseTable`, `UserTable`, `InvoiceTable`, `InquiryTable`, `GalleryTable`), forms (`Forms/AddCaseForm`, `CaseFeature/AddCaseLivewire`), shared UI (`Component/SidebarComponent`, `HeaderComponent`, `CalendarControlComponent`, `AutocompleteComponent`), `AppointmentsCalendar`
- **Blade** for public/marketing pages (`about`, `attorneys`, `contact`, `services`, `inquire`) + auth scaffolding (laravel/ui)
- When editing a feature, first determine which of the three rendering paths it lives on.

### Backend layers
- **15 Eloquent models** (`app/Models`): `User`, `LawCase` (central), `CaseClient`, `CaseCourt`, `CaseFiles`, `Client`, `Matter`, `SubMatter`, `Office`, `Invoice`, `InvoiceService`, `Entry` (timesheet/templates), `Inquiry`, `Gallery`, `Announcement`
- **Controllers** (`app/Http/Controllers`): resource controllers per domain + `Auth/*` (full auth scaffold), `Api/Invoke/GetTemplate` (single-action API); `TimesheetController` currently has only `index(): Response` (Inertia)
- **Routes:** `web.php` (59 lines) — everything behind `auth` middleware; nested resources `law-cases/{lawCase}/clients|courts|files`; `/case` group (CRUD + `download_file` via `Storage::path("public/case/…")`); `/timesheet`; `options`/`matters` limited to index+store+destroy; sub-matters nested under matters. `api.php` — Sanctum `auth:sanctum` `/user`, public `GET /api/template`
- **Middleware:** standard Laravel + `HandleInertiaRequests` + custom `EnsureHttps`
- **DB:** 21 migrations; core tables `users, clients, entries, matters, sub_matters, offices, law_cases, case_courts, case_clients, case_files, invoices, invoice_services, inquiries, galleries, announcements`; recent migrations (2026-11-01) added `law_cases` indexes, `case_files.file_path/file_size`, nullable `entries.is_template`

### Infra & testing
- **docker-compose:** services `app` (custom Dockerfile + `docker-entrypoint.sh`, nginx config in `nginx/`), `mysql:8.0`, `redis:7-alpine`, network `law-net`
- **Env defaults (.env.example):** `DB_CONNECTION=mysql`, `DB_DATABASE=law`, `CACHE_DRIVER=file`, `SESSION_DRIVER=file`, `QUEUE_CONNECTION=sync`, `BROADCAST_DRIVER=log`
- **Tests:** PHPUnit; Feature tests for every major controller + `InertiaSmokeTest` (`tests/Feature/`), `tests/Unit/Http`
- **Lint:** Laravel Pint

---

## 5. Kimi Work Environment

- **Runtime data root:** `/Users/renier.trenuela/Library/Application Support/kimi-desktop/daimon-share/daimon`
- **Workspace (this session):** `/Users/renier.trenuela/www/law/Y -  law` — rule: work here; copy outside files in before modifying.
- **Dashboards (Canvases):** "Dashboard basics", "Hello World"
- **Automation quota:** cron jobs 1/10 enabled; widget tasks 2/10 enabled (limits at scan time).
- **Installed plugin skills (usable on demand):**
  - Docs/data: kimi-word, kimi-excel, kimi-pdf, kimi-slides, pptx-surgical, kimi-design
  - Finance/data feeds: yahoo_finance, sec_edgar, imf, world_bank_open_data, igo_open_data, scholar
  - Comms: gmail
  - Build: kimix-website-publish (webapp/game/3D/publish), editor (3D), model3d_generation, image_generation, mobile-app-building (iOS/Android/WeChat)
  - Workflow: automation, binding, canvas, widget, deep-research, content-research-writer, seo-content-writer, review-team, skill-creator, plugin-builder, pet
- **Subagent policy (owner-set):** do NOT use subagents unless explicitly requested.

## 6. Owner Profile & Standing Preferences

- Name: Renier — Engineer & developer
- Role for the assistant: coding assistant for understanding, refactoring, implementation; framework-specific solutions; follow project conventions
- Output style: code blocks with file path header; label sections (Before/After/Explanation); list affected files first for multi-file changes; flag breaking changes in comments; minimal explanation unless asked
- Change policy: targeted edits, never regenerate whole files; match naming/structure; backward compatible unless told otherwise; meaningful error messages, no silent failures
- Always: check edge cases, performance, thread-safety; ask when uncertain (never assume import paths, DB schemas, API contracts, env vars without seeing them)

## 7. How to Use / Update This File

1. New session → say "Read AI_SYSTEM_GUIDE.md first" (or attach it) to skip environment discovery.
2. Something changed (new tool, project branch, OS update) → say "update the guide", and the assistant re-scans only the stale sections.
3. Sections most likely to drift: git branch (§3), Docker container/image counts (§2), routes/controllers/models as features grow (§4), automation quota (§5).
