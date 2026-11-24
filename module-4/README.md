# PeopleLink – Module 4: Matrimony

All Matrimony frontend, backend logic, migrations and API docs live in this folder. The module plugs into the existing PeopleLink backend (`matrimoney/`) through **one loader file**, so it shares the same login, session, CSRF, community lock, database and Razorpay engine as the other modules.

## Folder structure

```text
module-4/
├── Frontend/
│   ├── css/matrimony.css          one stylesheet (PeopleLink colours, responsive 1200 / 1024 / 720 / 420 px)
│   ├── js/mat-api.js              API client (fetch + CSRF), toasts, modal, cards, validation, pagination
│   ├── js/<page>.js               one small script per page
│   ├── images/
│   ├── components/                init.php (session/guards), header.php, footer.php, site-nav.php, site-footer.php
│   └── pages/                     15 pages (list below)
├── Backend/
│   ├── bootstrap.php              loaded by matrimoney/includes/ext/matrimony.php
│   ├── config/matrimony.php       module settings (no DB credentials here)
│   ├── controllers/               action registrations (wrap existing actions + new ones)
│   ├── models/                    ProfileModel, PackageModel, ContactModel
│   ├── services/                  NotificationService
│   ├── helpers/                   validation + shared helpers
│   └── uploads/                   (photos stay in matrimoney/uploads/photos so existing URLs keep working)
├── Database/migrations/001_matrimony_module4.sql
├── API_Documentation/API_List.md, API_Details.md
└── README.md
```

## Pages (`/peoplelink/module-4/Frontend/pages/`)

| Page | What it does |
|---|---|
| index.php | Matrimony home: quick search, newest profiles, how it works |
| search.php | Filters (real values from DB), sort, pagination, match % |
| profile.php?id= | Full profile, photos, send/withdraw/accept interest, save, contact request, report, block |
| profile-form.php | Create / edit profile (validated in browser and on server) |
| preferences.php | Partner preferences |
| photos.php | Upload (drag & drop), delete, set main photo, approval status |
| my-profile.php | Dashboard: counts, completion %, package, hide/show profile |
| interests.php | Received / Sent / Accepted interests |
| contacts.php | Contact requests received / sent |
| saved.php, visitors.php | Saved profiles, who viewed me |
| notifications.php | Matrimony alerts, mark read / all read |
| packages.php | Packages, Razorpay checkout, my package, payment history |
| privacy.php | Visibility, photo privacy, interest/contact switches, blocked list |
| support.php | Help ticket + my tickets |

The old matrimony pages in `first/` (and the old root pages) are now **301 redirects** to these pages, so existing links and menus keep working.

## Files changed outside module-4 (minimal)

| File | Change |
|---|---|
| `matrimoney/includes/ext/matrimony.php` | **New** – 3-line loader for `module-4/Backend/bootstrap.php` |
| `matrimoney/includes/modules.php` | Packages admin form: new field “Matrimony: contact requests allowed” |
| `first/*matrimony*.php`, `first/matrimony/community-matrimony.php`, root `matrimony-home.php`, `profile-details.php`, `manage-photos.php` | Replaced with redirects to module-4 |
| `first/js/matrimony-global.js` | Removed fake “View contact” alert and fake support ticket ID |
| `first/api.php` | Removed the unsafe matrimony `send_interest` block (wrong sender, fallback user 1) |
| `matrimoney/api.php`, `matrimoney/config.php` | CSRF failure status 419 → 403 (Apache sent unknown 419 as 500 Internal Server Error) |

## Setup / deploy

1. Upload `module-4/` to `public_html/peoplelink/module-4/` (next to `first/` and `matrimoney/`).
2. Upload the changed files listed above.
3. Run `Database/migrations/001_matrimony_module4.sql` in phpMyAdmin (additive only and safe to run again: columns and indexes are added only when missing). It copies `matrimony_packages` into `packages` with `module_key='matrimony'`.
4. Dashboard › Packages: set **contact requests allowed** for each matrimony package (empty = unlimited) and add features.
5. `matrimoney/config.php`: set `RAZORPAY_KEY_ID`, `RAZORPAY_KEY_SECRET`, `RAZORPAY_WEBHOOK_SECRET`. Webhook URL: `…/peoplelink/matrimoney/razorpay-webhook.php`.
6. Make sure `matrimoney/uploads/photos/` is writable.
7. Entry URL: `https://eliteinteriorstudios.com/peoplelink/module-4/Frontend/pages/index.php`

## Business rules implemented

- Age from date of birth, 18–80 only. Profile goes to **pending** on create and after editing an approved profile.
- Search shows only approved + active profiles of the member's community, opposite gender, never blocked profiles.
- Contact details are visible after an **accepted interest** or an **approved contact request**.
- Contact request = 1 credit from an active matrimony package (`user_packages.posts_used`); a declined or cancelled request returns the credit. Credit use and refunds are atomic, so double clicks or parallel calls cannot go over the package limit or refund twice.
- An interest can be accepted or declined only while it is pending (`409 ALREADY_ANSWERED` otherwise).
- Expired / wrong CSRF token returns **HTTP 403** with `code: CSRF_INVALID` (419 was turned into 500 by Apache).
- Payments: `order_package` → Razorpay Checkout → `payment_verify` (webhook backup). Price always read on the server.
- Notifications go to the common `user_notifications` table (type `matrimony`) with FCM push when configured; older admin notices from `matrimony_notifications` are shown too.
- Match % = share of the viewer's partner preferences the profile meets (age, location, education, profession, marital status, mother tongue).

## Development checklist

- [x] Folder structure created
- [x] Existing files reviewed
- [x] Client requirements mapped (Phase 1 Matrimony scope from the PeopleLink spec)
- [x] Frontend pages identified
- [x] Backend functionality identified
- [x] Database tables mapped
- [x] Required API list prepared
- [x] API documentation updated alongside development
- [x] Frontend completed
- [x] Backend APIs implemented
- [x] Frontend and backend integrated
- [x] End-to-end testing completed (locally, see below)
- [x] Mobile responsiveness verified (390 px and 1280 px)
- [x] Final API documentation updated

## Local test results (15 Nov 2026, PHP 8.3 + MariaDB, imported SQL dump)

Passed: register/login, create profile (incl. underage and bad-mobile rejection), validation messages, preferences, match %, photo upload / main photo, admin approval in the dashboard, search filters + opposite-gender + block exclusion, send / duplicate / accept interest, contact visible after accept, contact request without package (PACKAGE_REQUIRED), with package, credit used, decline returns credit, approve shows phone, save/unsave, report (self-report and duplicate blocked), notifications + mark read, visitors, support ticket, redirects from old pages, all 15 pages on desktop and mobile with no JavaScript errors.

Not testable locally: real Razorpay payment (no keys in config – order creation correctly returns PAYMENT_FAILED) and FCM push (no service account).

## Known data issues in the current database (not changed automatically)

- Profile 7 has dob 2021-12-13 but age 26 – the migration lists such rows; correct the date with the member.
- Seed photos use relative paths (`profile/images/…`) that do not exist; the UI shows initials instead. Re-upload real photos.
- Some seed interests/payments point to profile ids that were later reused; delete test rows before go-live.
