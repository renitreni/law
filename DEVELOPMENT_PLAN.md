# Law Practice Management — React + Inertia + Laravel Upgrade

## Overview
Upgrade the existing Laravel/Livewire app to React.js + Inertia.js + Laravel.
Fix the law_cases migration. Remove MESHARI ALHUMAIDI traces. Remove homepage.
Adopt public/spark-admin theme as the UI design system.
Run one day at a time. Each day has its own validation + unit tests.

---

## Day 0 — Cleanup: Remove MESHARI traces + Remove homepage

### Goal
Scrub all MESHARI ALHUMAIDI LAW FIRM branding and remove the public homepage.

### Tasks
1. Create feature branch from main:
   ```bash
   git checkout main && git pull origin main
   git checkout -b feat-inertia-react-upgrade
   ```
2. Remove MESHARI traces from Blade views:
   - `resources/views/layouts/guest/index.blade.php` — replace meta description, og:title, og:description, og:url with generic values
   - `resources/views/includes/section-hero.blade.php` — replace `<h4> MESHARI ALHUMAIDI LAW FIRM</h4>` with generic heading
   - `resources/views/includes/footer.blade.php` — replace brand name, description, copyright, email, LinkedIn URL
   - `resources/lang/ar.json` — remove/replace "Welcome To Meshari Alhumaidi Law Firm" entry
3. Remove homepage:
   - Delete `resources/views/welcome.blade.php`
   - Remove the `/{lang?}` route group (welcome/about/attorneys/services/galleries/contact/inquire routes) from `routes/web.php`
   - Remove `HomeController::index` (and optionally the now-unused controller methods if no other route uses them)
4. Verify no remaining "Meshari"/"Alhumaidi" references:
   ```bash
---

## Day 2 — Fix law_cases Migration + Model

### Goal
Resolve the law_cases migration issue via a new migration (do not edit committed migration files).

### Tasks
1. Create new migration:
   ```bash
   php artisan make:migration add_indexes_to_law_cases_table
   ```
2. In `up()` add indexes on frequently-filtered columns:
   ```php
   Schema::table('law_cases', function (Blueprint $table) {
       $table->index('case_category');
       $table->index('case_status');
       $table->index('case_date');
   });
   ```
   In `down()` drop those indexes.
3. Run migrations fresh in testing DB:
   ```bash
   php artisan migrate:fresh --env=testing
   ```

### Validation
```bash
vendor/bin/phpunit tests/Unit/Migrations/LawCaseMigrationTest.php
```
Test asserts: `law_cases` table exists; columns `case_plaintiff`, `case_defendant`, `case_category`, `case_status`, `case_date` exist; indexes exist on `case_category`, `case_status`, `case_date`.

**Definition of Done:** New migration applied; indexes present; LawCase model intact; migration tests green.

---

## Day 3 — LawCase Inertia Controllers + Routes + Tests

### Goal
Laravel controllers + routes serving Inertia responses for LawCase CRUD, fully unit-tested.

### Tasks
1. Generate controller + form requests:
   ```bash
   php artisan make:controller LawCaseController --model=LawCase
   php artisan make:request LawCaseStoreRequest
   php artisan make:request LawCaseUpdateRequest
   ```
2. Implement `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` — each returns `inertia('LawCase/Action', [...])`.
3. Add validation in `LawCaseStoreRequest` / `LawCaseUpdateRequest` (plaintiff, defendant, category, status, description, attorney, date required).
4. Add resource route inside `auth` middleware group in `routes/web.php`:
   ```php
   Route::resource('law-cases', LawCaseController::class);
   ```

### Validation
```bash
vendor/bin/phpunit tests/Feature/LawCaseControllerTest.php
```
Tests: index 200, store creates + assertDatabaseHas + redirect, update, destroy (soft delete), validation rejects missing required fields.

**Definition of Done:** Controller + routes + requests exist; all controller feature tests green; data persists to `law_cases`.

---

## Day 4 — React Pages for LawCase CRUD (Spark Admin Theme)

### Goal
React pages (index, create, edit, show) wired to Inertia controllers, styled with Spark Admin theme.

### Tasks
1. Create shared layout `resources/js/Layouts/AppLayout.jsx` — Spark Admin sidebar + top navbar + `@inertia` child outlet.
2. Pages:
   - `resources/js/pages/LawCase/Index.jsx` — table listing cases (plaintiff/defendant/status/date), delete action, Spark Admin table styling
   - `resources/js/pages/LawCase/Create.jsx` — form POST to `law-cases.store`
   - `resources/js/pages/LawCase/Edit.jsx` — form PUT/PATCH to `law-cases.update`
   - `resources/js/pages/LawCase/Show.jsx` — read-only view
3. Use `useForm` from `@inertiajs/react` for forms; `Link` / `router` for navigation & deletes.
4. Controller `index` passes cases; `create`/`edit` pass empty/model data.

### Validation
```bash
vendor/bin/phpunit tests/Feature/LawCasePageTest.php
```
Tests: assert Inertia page component names (`LawCase/Index`, `LawCase/Create`, `LawCase/Edit`, `LawCase/Show`).

**Definition of Done:** All 4 React pages render; CRUD works end-to-end; page-component assertions green.

---

## Day 5 — Related Entities (CaseClient, CaseCourt, CaseFiles) + Tests

### Goal
Nested CRUD for case clients, courts, files under a LawCase, in Inertia + React.

### Tasks
1. Controllers: `CaseClientController`, `CaseCourtController`, `CaseFileController`.
2. Nested routes:
   ```php
   Route::prefix('law-cases/{lawCase}')->group(function () {
       Route::resource('clients', CaseClientController::class);
       Route::resource('courts', CaseCourtController::class);
       Route::resource('files', CaseFileController::class);
   });
   ```
3. React pages under `resources/js/pages/LawCase/`:
   - `Client/Create.jsx`, `Court/Create.jsx`, `File/Upload.jsx`
4. File upload via `useForm` + Inertia `post()` with `transformRequest` (FormData).

### Validation
```bash
vendor/bin/phpunit tests/Feature/CaseClientControllerTest.php
vendor/bin/phpunit tests/Feature/CaseCourtControllerTest.php
vendor/bin/phpunit tests/Feature/CaseFileControllerTest.php
```
Tests: create/assert for each related table under a law case.

**Definition of Done:** Related entities creatable/listable/deletable under a case; all three controller test files green.

---

## Day 6 — Full Test Suite, Lint, Build, Sign-off

### Goal
Everything green; production build works; commit on feature branch.

### Tasks
1. Run full PHPUnit suite:
   ```bash
   vendor/bin/phpunit
   ```
2. Fix any failures from Days 0–5.
3. Lint/format PHP:
   ```bash
   vendor/bin/pint --test
   ```
4. Production frontend build:
   ```bash
   npm run build
   ```
5. Commit:
   ```bash
   git add -A
   git commit -m "feat: upgrade to React + Inertia + Laravel; fix law_cases migration; remove MESHARI traces & homepage; adopt Spark Admin theme"
   git push origin feat-inertia-react-upgrade
   ```
   (Open a PR to main — never push directly to main.)

### Validation
```bash
vendor/bin/phpunit
vendor/bin/pint --test
npm run build
```
**Definition of Done:** Full suite green, Pint clean, `npm run build` succeeds, committed on feature branch, PR opened to main.
   grep -ri "meshari\|alhumaidi" resources/ routes/ app/ lang/ public/ --include="*.php" --include="*.json" --include="*.blade.php" || true
   ```

### Validation
```bash
vendor/bin/phpunit
```
**Definition of Done:** Zero MESHARI traces remain; homepage route removed; test suite still green.

---

## Day 1 — Inertia.js + React.js Foundation

### Goal
Install Inertia (Laravel) + React (client), wire Vite, and prove a React page renders via Inertia.

### Tasks
1. Install server package:
   ```bash
   composer require inertiajs/inertia-laravel
   php artisan inertia:publish
   ```
2. Register `HandleInertiaRequests` middleware in `app/Http/Kernel.php` (web group).
3. Install client packages:
   ```bash
   npm install @inertiajs/react @inertiajs/inertia react react-dom
   npm install -D @vitejs/plugin-react
   ```
4. Update `vite.config.js` — add `@vitejs/plugin-react()` react plugin.
5. Create root template (`resources/views/app.blade.php`) with `@inertia` head/body directives, loading Spark Admin CSS:
   ```html
   <link rel="stylesheet" href="{{ asset('spark-admin/assets/css/main.css') }}">
   <link rel="stylesheet" href="{{ asset('spark-admin/assets/libs/bootstrap/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('spark-admin/assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
   @vite('resources/js/app.js')
   ```
6. Create `resources/js/app.js` — bootstrap Inertia + React:
   ```js
   import { createInertiaApp } from '@inertiajs/react'
   import { createRoot } from 'react-dom/client'
   ...
   ```
7. Add a smoke-test route:
   ```php
   Route::get('/inertia-test', function () {
       return inertia('Welcome', ['message' => 'Inertia + React works']);
   })->name('inertia.test');
   ```
8. Create `resources/js/pages/Welcome.jsx` — simple React page rendering the message.

### Validation
```bash
# Terminal 1
php artisan serve
# Terminal 2
npm run dev
# Open http://localhost:8000/inertia-test → expect React-rendered page

vendor/bin/phpunit tests/Feature/InertiaSmokeTest.php
```
**Definition of Done:** Branch created; composer/npm installs clean; `/inertia-test` renders React via Inertia; smoke test green.

---

## Day 2 — Fix law_cases Migration + Model