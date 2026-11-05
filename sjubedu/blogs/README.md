# SJU Blog — `blogs.sju.edu.in`

A lightweight, self-hosted blog platform for **St Joseph's University, Bengaluru**, running as a standalone subdomain on the existing AWS EC2 / PHP 8.x stack. Built to match the SJU brand system, work with Cloudflare CDN for zero extra hosting cost, and rank well with both Google and AI search engines.

---

## Directory Structure

```
sjubedu/blogs/                   ← Document root for blogs.sju.edu.in
│
├── index.php                    Blog listing (search, category filter, pagination)
├── post.php                     Single article (WYSIWYG content, like, share, related)
├── like_handler.php             AJAX endpoint — increments like count
├── header.php                   Full SJU nav (absolute URLs → www.sju.edu.in)
├── footer.php                   Full SJU footer + backlink strip → sju.edu.in
├── admin_config.php             Admin credentials — CHANGE before deploying
├── schema.sql                   Database schema — run once against existing DB
├── sitemap.php                  Dynamic XML sitemap (Cloudflare-cached 24 h)
├── llms.txt                     LLM/AI crawler discovery file
├── .htaccess                    Cloudflare cache headers + security rules
│
├── admin/                       CMS — accessible at /admin/
│   ├── login.php                Login page (rate-limited: 5 attempts → 15 min lock)
│   ├── logout.php               Destroys session, redirects to login
│   ├── index.php                Dashboard — post list, stats, filters
│   ├── edit.php                 Create / edit post (Summernote WYSIWYG + raw HTML)
│   ├── delete.php               CSRF-protected delete (removes DB row + image)
│   ├── upload.php               In-editor image upload (called by Summernote)
│   ├── categories.php           Add / delete categories
│   ├── auth.php                 Session guard + shared helpers (DB, CSRF, flash)
│   └── .htaccess                no-store cache + noindex for all admin pages
│
└── uploads/
    └── blog/                    Featured images + inline editor images live here
```

---

## Database Setup

The blog shares the existing main-site database (`DB_NAME` from `/home/sjubedu/config.php`). Run the schema once:

```sql
-- From uploads/blogs/schema.sql
CREATE TABLE IF NOT EXISTS blog_categories ( ... );
CREATE TABLE IF NOT EXISTS blog_posts ( ... );

-- Default categories seeded automatically:
-- Academics, Campus Life, Research, Placements, Events, Faculty Spotlight
```

**Key columns in `blog_posts`:**

| Column | Type | Notes |
|---|---|---|
| `id` | INT | Auto-increment primary key |
| `title` | VARCHAR(255) | Post title |
| `slug` | VARCHAR(255) | URL-safe unique identifier |
| `excerpt` | VARCHAR(500) | Short summary shown on listing |
| `content` | LONGTEXT | Full HTML content |
| `featured_img` | VARCHAR(255) | Filename only — file lives in `uploads/blog/` |
| `category_id` | INT | FK → `blog_categories.id` |
| `author` | VARCHAR(100) | Default: `SJU Editorial` |
| `like_count` | INT UNSIGNED | Incremented by AJAX likes |
| `is_published` | TINYINT(1) | `1` = live, `0` = draft |

---

## Server / Hosting Setup

### 1. Point the subdomain

In cPanel (or AWS Route 53), create a subdomain `blogs.sju.edu.in` pointing to this directory as its document root.

### 2. Cloudflare DNS

Proxy the subdomain through Cloudflare (orange cloud). Cache rules are set via `.htaccess` response headers — no extra Cloudflare page rules needed.

### 3. PHP config

Requires PHP 8.0+ with PDO MySQL and the `fileinfo` extension (both enabled on the existing server).

### 4. Upload permissions

```bash
chmod 755 uploads/blog/
```

### 5. Run schema

```bash
mysql -u DB_USER -p DB_NAME < schema.sql
```

---

## Admin Panel

**URL:** `https://blogs.sju.edu.in/admin/login.php`

| Setting | Default |
|---|---|
| Username | `sjublogadmin` |
| Password | `SJUBlog@2024` |

> **Change the password before deploying.** Open `admin_config.php` and update `BLOG_ADMIN_PASS`.

### Writing a post

1. Go to **New Post** in the sidebar.
2. Enter a **Title** — the slug auto-generates from it.
3. Choose a **Category** and **Author**.
4. Write in the **Summernote** editor (WYSIWYG by default).
5. Click the **`</>`** button in the toolbar to switch to raw HTML mode and edit markup directly.
6. Upload a **Featured Image** (JPG/PNG/GIF/WebP, max 5 MB).
7. Toggle **Published** on, then click **Publish Post**.

Images dragged or pasted into the editor are uploaded automatically to `uploads/blog/` via `upload.php`.

---

## Cloudflare Caching Strategy

| Resource | `Cache-Control` | Effect |
|---|---|---|
| Blog images (`uploads/blog/`) | `public, s-maxage=31536000, immutable` | Cloudflare serves for **1 year** — no origin hit |
| Blog pages (`index.php`, `post.php`) | `public, s-maxage=3600, max-age=0` | Cloudflare caches **1 hour**; browser always fetches from edge, not EC2 |
| Sitemap + `llms.txt` | `public, s-maxage=86400` | Edge-cached **24 hours** |
| Admin pages | `no-store, private` | Never cached anywhere |
| `like_handler.php` | `no-store` | POST endpoint, never cached |

Gzip compression is also enabled in `.htaccess`, reducing bytes transferred off EC2.

---

## SEO & AI Ranking

### `llms.txt`

Located at `https://blogs.sju.edu.in/llms.txt`. Tells AI systems (ChatGPT browsing, Perplexity, Google AI Overview, etc.) what the blog covers, which URLs to index, and attribution rules. Modelled on the emerging `llms.txt` convention.

### `sitemap.php`

Dynamic XML sitemap at `https://blogs.sju.edu.in/sitemap.php`. Regenerated from the live database on each request; Cloudflare caches the response for 24 hours. Submit this URL in Google Search Console.

### JSON-LD Article Schema

Every `post.php` page includes a `<script type="application/ld+json">` block with:
- `schema.org/Article` type
- `headline`, `datePublished`, `dateModified`, `author`, `publisher`, `image`, `articleSection`
- Publisher linked to `https://www.sju.edu.in/#university`

This enables rich results in Google and structured extraction by AI knowledge bases.

### Open Graph + Twitter Card

Full OG and Twitter Card meta tags on every post, including `og:image` for link previews on Facebook, LinkedIn, and WhatsApp.

### Backlinks to `sju.edu.in`

The footer contains a contextual dofollow backlink strip pointing to 10 key pages on `www.sju.edu.in` (About, Programmes, Admissions, Placements, Research, Library, Faculty, Alumni, Scholarships, IQAC). These pass link equity from the blog subdomain back to the main domain.

---

## Share Buttons

### On every post card (listing page)
Facebook · Twitter · LinkedIn · WhatsApp

### On the article page
- **Floating sidebar** (desktop ≥ 1100 px) — fixed on the left of the reading column
- **Engagement bar** (all screen sizes) — Facebook, Twitter, LinkedIn, WhatsApp, Copy Link
- **Like button** — AJAX, state persisted in `localStorage` per post

---

## Responsive Breakpoints

The layout uses CSS `clamp()` and `auto-fill` grids — no hardcoded pixel breakpoints for content.

| Screen | Card grid | Font scale |
|---|---|---|
| Phone (< 600 px) | 1 column | `clamp()` floor |
| iPad (600–1024 px) | 2 columns | Mid-range |
| Desktop (1024–1920 px) | 3–4 columns | Comfortable reading width |
| 100-inch / 4K | 4+ columns, max-width 1600 px | `clamp()` ceiling |

Admin sidebar collapses to an off-canvas drawer on screens narrower than 900 px, toggled by a hamburger button.

---

## Security Notes

- All SQL uses **PDO prepared statements** — no injection risk.
- Admin session is **regenerated on login** to prevent fixation.
- Login is **rate-limited** (5 failed attempts triggers a 15-minute lockout stored in session).
- Image uploads are validated by **MIME type** via `finfo` (not just file extension).
- CSRF tokens are verified on every state-changing form (create, edit, delete, upload).
- `admin_config.php` and `auth.php` are blocked from direct HTTP access via `.htaccess`.
- `display_errors` is forced off in `.htaccess`.

---

## Dependencies

All loaded from CDN — nothing to `npm install` or `composer install`.

| Library | Version | Used for |
|---|---|---|
| Bootstrap | 5.3.3 | Layout, components |
| Font Awesome | (SJU CDN) | Icons |
| Summernote | 0.8.18 | Admin WYSIWYG editor (Bootstrap 5 build) |
| jQuery | 3.7.1 | Required by Summernote |
| Google Fonts | — | Playfair Display, Plus Jakarta Sans, Urbanist |

Assets for the public blog (Bootstrap CSS, FontAwesome, `style.css`, `main.js`) are loaded from `https://www.sju.edu.in/assets/` — no duplication, Cloudflare already caches them there.

---

## Quick Reference

```
Public blog:     https://blogs.sju.edu.in/
Single post:     https://blogs.sju.edu.in/post.php?slug={slug}
Admin panel:     https://blogs.sju.edu.in/admin/login.php
Sitemap:         https://blogs.sju.edu.in/sitemap.php
LLM discovery:  https://blogs.sju.edu.in/llms.txt
Like endpoint:   POST https://blogs.sju.edu.in/like_handler.php  { post_id: N }
Image uploads:   /uploads/blog/{random-hex}.{ext}
```

---

*Maintained by the SJU Web Team · [desk@sju.edu.in](mailto:desk@sju.edu.in) · [www.sju.edu.in](https://www.sju.edu.in)*
