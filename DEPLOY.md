# SJU Website — Deployment Guide

Quick reference for deploying website changes to `www.sju.edu.in` (cPanel / SFTP on the AlmaLinux EC2 instance behind Cloudflare).

---

## Deploying SEO Changes (Current Batch)

The file `SEO_FIXES_ALL_FILES.txt` (repo root, ~11 MB) contains every changed PHP file in full.
Copy any file listed there to the matching path under `/home/sjubedu/public_html/` on the server.

**Fastest method — SFTP bulk upload (FileZilla / WinSCP):**
1. Connect to the server with your SFTP credentials.
2. Navigate to `/home/sjubedu/public_html/`.
3. Upload only the files that changed (use `git diff --name-only` to get the list).

**Fastest method — cPanel File Manager:**
1. Open File Manager → `/home/sjubedu/public_html/`.
2. For each changed file, use **Upload** to overwrite the existing file.

**After upload — clear Cloudflare cache:**
```
Cloudflare Dashboard → sjubedu → Caching → Purge Everything
```
Or purge individual URLs via API / Dashboard for targeted cache busts.

---

## What Changed in This Batch

| Category | Count | What was fixed |
|---|---|---|
| Programme wrappers | ~146 | Unique `<title>`, `<meta description>`, `<link rel=canonical>`, Course JSON-LD |
| School landing pages | 12 | Unique title/desc/canonical, EducationalOrganization JSON-LD |
| Department landing pages | ~40 | Unique title/desc/canonical, EducationalOrganization JSON-LD |
| About / IQAC pages | 28 | Unique title/desc/canonical |
| Admissions pages | 10 | Unique title/desc/canonical |
| Library pages | 16 | Unique title/desc/canonical |
| Services pages (NCC, NSS, hostel…) | ~110 | Unique title/desc/canonical |
| Student council pages | 10 | Unique title/desc/keywords/canonical (new content pages) |
| Communication dept (from SEO doc) | 16 | Full keyword-specific SEO copy |
| **Total** | **~600** | — |

---

## Checking After Deployment

```bash
# From server SSH — verify a few canonical tags landed
grep -r 'rel="canonical"' /home/sjubedu/public_html/about/ | head -5

# Confirm no pages still have the generic title
grep -r '<title>St Joseph' /home/sjubedu/public_html/about/ | head -5
```

**Google Search Console:**
- After deploying, trigger a re-crawl: GSC → URL Inspection → "Request Indexing" for key pages.
- Submit the updated sitemap if any new pages were added.

---

## Clean URL Rewrite (reference)

`.htaccess` does two things for URLs:
1. `RewriteRule ^(.*)\.php$ /$1 [R=301,L]` — strips `.php` extension on incoming requests.
2. `RewriteRule ^(.+?)/?$ $1.php [L]` — internally rewrites clean URL back to the PHP file.

Always write internal links and canonical tags **without** `.php`:
```html
<!-- Correct -->
<link rel="canonical" href="https://www.sju.edu.in/about/contact-us">
<a href="/admissions/admissions">Apply Now</a>

<!-- Wrong -->
<link rel="canonical" href="https://www.sju.edu.in/about/contact-us.php">
```

---

## Server Paths Quick Reference

| What | Path on server |
|---|---|
| Document root | `/home/sjubedu/public_html/` |
| Shared header/footer | `public_html/header.php`, `public_html/footer.php` |
| Programme content fragments | `public_html/programmes/*.php` |
| Faculty profile template | `public_html/Test/i_db.php` (shared by ~450 pages — change carefully) |
| Assets (CSS/JS) | `public_html/assets/` |
| Blog document root | `/home/sjubedu/blogs/` |
| Main `.htaccess` | `public_html/.htaccess` (controls URL rewrite, CSP, caching) |

---

## Google Search Rankings — Key Next Steps

Beyond technical SEO (now done), the levers for ranking above competing colleges:

### 1. Submit sitemap & request indexing
- GSC → Sitemaps → `https://www.sju.edu.in/sitemap.xml` (verify it's up to date).
- Inspect and request indexing for the 10 highest-priority pages (homepage, admissions, top programme pages).

### 2. Core Web Vitals
- Run Lighthouse on `www.sju.edu.in` — target LCP < 2.5 s, CLS < 0.1.
- Cloudflare already caches static assets. Next bottleneck is usually unoptimised hero images — convert to WebP, add `width`/`height` attributes to stop CLS.

### 3. Content depth on high-intent pages
High-traffic queries: `"BCom college Bengaluru"`, `"MSc Biotechnology Bengaluru"`, `"MBA Bangalore Jesuit"`.
- Programme pages should have: syllabus highlights, placement stats, faculty names, alumni testimonials, fee structure.
- The more genuinely useful content, the longer dwell time — a key ranking signal.

### 4. Internal linking
- Programme pages should link to each other and to the school landing page.
- The homepage and admissions page should link to all programme pages.

### 5. External backlinks
- The blog subdomain (`blogs.sju.edu.in`) already has dofollow backlinks to 10 key pages.
- Press releases in education media (Deccan Herald, Times of India Education, Shiksha.com listings) add authority.

### 6. Google Knowledge Panel
- Ensure the `EducationalOrganization` JSON-LD on the homepage references `sameAs` to the Wikipedia article and Wikidata ID for SJU — this signals Google to build/update the Knowledge Panel.

---

*Maintained by SJU Web Team · [desk@sju.edu.in](mailto:desk@sju.edu.in)*
