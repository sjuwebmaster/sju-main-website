# SJUNew

Source for **St Joseph's University, Bengaluru**'s public website (`www.sju.edu.in`) and its blog subdomain (`blogs.sju.edu.in`). Plain PHP, no build step — pages are deployed by copying files to the server.

## Repository Layout

```
sjubedu/
├── public_html/     Document root for www.sju.edu.in
│   ├── header.php / footer.php   Shared site chrome, included by every page
│   ├── gtm.php                   Google Tag Manager snippet, included in every <head>
│   ├── assets/                   CSS, JS, fonts, images shared across the site
│   ├── programmes/               Shared per-course content fragments, included by
│   │                             department programme pages (admissions, eligibility,
│   │                             syllabus, fees, etc.)
│   ├── about/, admissions/, services/, school-of-*/   Section and school directories
│   └── school-of-*/department-of-*/                   Department pages: landing page,
│                                                        programme pages, faculty profiles
└── blogs/           Document root for blogs.sju.edu.in (see blogs/README.md)
```

Each school follows the same pattern: `school-of-x/school-of-x.php` is the school landing
page, linking to one or more `department-of-x/department-of-x.php` pages, which in turn
link to individual programme pages (e.g. `ba-in-visual-communication.php`). Programme pages
are thin wrappers — breadcrumb + `<?php include '../../programmes/<slug>.php'; ?>` — so the
actual programme content lives once in `public_html/programmes/` and is reused by the
wrapper.

Faculty profile pages (e.g. `MTA1MQ.php`) are minimal stubs that set a `$FACULTY_ID` and
`require_once '.../Test/i_db.php'`, a shared template that pulls live staff data from the
Linways API (with DB caching). This template is included by ~450 pages site-wide — treat it
as shared infrastructure and test broadly before changing it.

## Conventions

- No templating engine: every page repeats the same `<head>` block (Bootstrap, Font
  Awesome, Google Fonts, `assets/css/style.css`) and includes `header.php` / `footer.php`
  for nav and footer.
- Each page should have a **unique `<title>` and `<meta name="description">`** — many
  legacy pages still ship the generic `St Joseph's University, Bengaluru` title and should
  be updated to page-specific copy (with `<link rel="canonical">` and
  `application/ld+json` `Course`/`EducationalOrganization` schema) when touched.
- Internal site URLs drop the `.php` extension. `.htaccess` 301-redirects any request
  containing `.php` to the clean URL, then internally rewrites the clean URL back to the
  `.php` file — write canonical and internal links without the extension
  (`/about/contact-us`, not `/about/contact-us.php`).
- Images and other large media are served from AWS S3 (`sjub.s3.ap-south-1.amazonaws.com`,
  `sjudata.s3.ap-south-1.amazonaws.com`), not committed to the repo. The S3 origins are
  explicitly whitelisted in the CSP `img-src`/`frame-src` in `.htaccess` — adding a new
  external asset host or third-party widget requires updating that CSP too, or the browser
  will silently block it.
- `.gitignore` allow-lists source file types (`.php`, `.html`, `.css`, `.js`, `.md`, etc.)
  rather than ignoring build artifacts, since there is no build step.

## Server & Security Reference

Production runs on an AWS EC2 instance (AlmaLinux + cPanel/WHM), Apache + PHP-FPM 8.2,
behind Cloudflare. `public_html/.htaccess` is the single control point for PHP runtime
settings, the clean-URL rewrite, caching, a lightweight WAF, and the Content Security
Policy — see [sjubedu/public_html/Test/README.md](sjubedu/public_html/Test/README.md) for
the full per-directive breakdown, the faculty-portal caching/monitoring system, and the
backup/cron schedule.

> **Note:** that file currently has AWS access keys committed in plaintext inside example
> shell commands. Treat them as compromised — rotate the keys in IAM and scrub them from
> the file (and ideally git history) before relying on this repo's history being safe to
> share.

## Blogs Subdomain

`sjubedu/blogs/` is a self-contained blog CMS for `blogs.sju.edu.in`, with its own admin
panel, database schema, and caching strategy. See [sjubedu/blogs/README.md](sjubedu/blogs/README.md)
for setup and deployment details.

## Deployment

There is no CI/build pipeline — changes are copied directly to the live server (cPanel /
SFTP) after testing locally or in a staging copy. When editing shared files (`header.php`,
`footer.php`, `programmes/*.php`, `Test/i_db.php`), check how many pages include them before
changing behaviour, since a single shared file can affect hundreds of pages.

So there are 451 non-faculty pages with a generic title. The biggest categories are:

services: 148 files
about: 39 files
student-support: 33 files
school-of-humanities-and-social-sciences: 22 files
whysju: 20 files
school-of-life-sciences: 19 files
school-of-languages-and-literatures: 26 files
library: 16 files
internationalstudents: 13 files
placements: 12 files
school-of-physical-sciences: 13 files
admissions: 10 files
school-of-business: 10 files
examination: 9 files
departmental-research: 8 files
school-of-information-technology: 7 files
school-of-chemical-sciences: 5 files
school-of-social-work: 5 files
bulletin: 4 files
root: 28 files
programmes: 1 file
programmes2222222: 1 file
Test: 1 file
V2: 1 file