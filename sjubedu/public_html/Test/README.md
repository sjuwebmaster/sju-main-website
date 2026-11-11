# 🛡️ SJU Faculty Portal: Management & Master Monitor Suite (v3.7)

**A High-Performance Middleware, Centralized Profile Manager & Traffic Analytics System.**

This system acts as a high-availability bridge between the **Linways API** and the SJU public portal. Designed for the **AWS t3.medium** environment, it ensures that faculty profiles remain accessible to **10,000+ students** even during upstream API failures or server resource spikes.

---

## 🚀 Key Features

### 1. Faculty Profile Management (v2.1)

* **Resilient Caching**: Served via local MySQL. If the API is down, the system extends the life of expired data to prevent "blackouts."
* **Zero-Downtime Sync**: Bulk imports use `REPLACE INTO` logic to update records row-by-row without locking the main tables.
* **Multi-Module Cache**: Separate caching for Faculty, PhD, Publications, Projects, Awards, Patents, Book Chapters, Books Published, Consultancy, Events Organized, and Popular Media.

### 2. Master Monitor & Security (v3.5)

* **Intelligent Health Grading**: Automated **A-F scoring** based on CPU load (Warning at **1.8**, Critical at **2.5**).
* **Silent Error Engine**: Monitoring logic uses a **2s DB timeout**—if the analytics DB hangs, the user experience is unaffected.
* **Cybersecurity Tools**: Native IP nicknaming, bulk blocking, and Cloudflare-compatible IP detection.
* **Global Tracker**: Integrated visitor tracking across all public-facing pages.

### 3. Emergency Recovery (v3.6)

* **Nuclear Reset**: A secure, key-gated script to wipe all cache and tracking tables simultaneously in case of data corruption or server overload.

---

## 📂 File Structure

### **Core Management & Profiles**

* `dashboard.php`: Main control panel for stats, API latency, and logs.
* `i_db.php`: Public-facing profile template; handles the fallback logic.
* `config.php`: Sensitive credentials (stored above the public root for security).
* `maintenance.html`: Static page displayed when Maintenance Mode is active.
* `emergency_reset.php`: Nuclear option to wipe all databases (`key` required).
* `maintenance_watchdog.php`: Safety script to auto-disable maintenance mode after 2 hours.

### **Monitoring & Automation**

* `global_tracker.php`: The "Silent" tracking engine included in all profile headers.
* `Health_check.php`: Visual dashboard for cache freshness and server load.
* `master_sync.php`: Background script for full module synchronization.
* `bulk_import.php`: Manual bulk import tool with logging.

### **Module Generators**


* `master_generator.php`: Unified generator that runs all individual module generators in sequence (CLI & UI supported).
* `bulk_*_generator.php`: Generates static PHP files for specific modules (e.g., `bulk_events_organized_generator.php`).
* `bulk_*_live_generator.php`: Generates live-fetch versions of module pages.

### **Database & Sync Workers**

* `cron_update_all.php`: Primary sync script for Faculty Profiles (populates `api_cache`).
* `bulk_*_cron.php`: Modular background scripts that populate specific tables (e.g., `phd_cache`).
* `force_purge.php`: Emergency utility to truncate the main cache table.
* `db_speed_test.php`: Benchmarks database connection and query latency.

#### **Difference: `cron_update_all.php` vs `bulk_import.php`**

| Feature | `cron_update_all.php` | `bulk_import.php` |
| :--- | :--- | :--- |
| **Primary Purpose** | **Automated Sync:** Designed for server cron jobs (CLI). | **Manual Sync:** Designed for admin browser execution. |
| **Output** | Plain text logs. | Visual HTML progress bar. |
| **Rate Limiting** | Aggressive (0.3s delay). | Conservative (0.9s delay). |

### **⚙️ Configuration Core (config.php)**

The `config.php` file is the **heart** of the system. It is located **outside** the public HTML directory for security.

**Key Responsibilities:**
1.  **Credentials**: Stores MySQL login details and the Linways API Token.
2.  **Form IDs**: Centralized mapping of Linways Form IDs for all modules (PhD, Publications, etc.).
3.  **Department List**: The master array of Department IDs and Names used by generators.
4.  **Security Layer**:
    *   **IP Restoration**: Restores real visitor IPs if behind Cloudflare.
    *   **Firewall**: Checks `banned_ips` table and blocks access immediately if listed.
    *   **Global Tracker**: Automatically logs visitor traffic to `active_visitors` on every page load.

---

## 🛠️ Database Schema (SQL)

### **Database 1: Traffic & Security**

```sql
CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50) NOT NULL,
    carrier VARCHAR(100) DEFAULT 'Unknown',
    hit_count INT DEFAULT 1,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS banned_ips (
    ip_address VARCHAR(45) PRIMARY KEY,
    banned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ip_nicknames (
    ip_address VARCHAR(45) PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 4. Global Settings (Maintenance Mode)
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value VARCHAR(255)
) ENGINE=InnoDB;

INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('maintenance_mode', 'off');
```

### **Database 2: Faculty Data Cache**

```sql
CREATE TABLE `api_cache` (
  `id` varchar(255) PRIMARY KEY,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `fail_count` int(11) DEFAULT '0'
) ENGINE=InnoDB;
-- Also includes: phd_cache, publication_cache, project_cache, awards_cache

```

---

## 🤖 Automation & Background Commands

### **Manual Master Sync**

To run the full sync in the background so you can close your terminal:

```bash
nohup php /home/sjubedu/public_html/Test/master_sync.php > /home/sjubedu/public_html/Test/master_sync.log 2>&1 &

nohup php /home/sjubedu/public_html/Test/cron_update_all.php > /home/sjubedu/public_html/Test/master_sync.log 2>&1 &
```

### **Background Bulk Import**

```bash
sudo nohup php /home/sjubedu/public_html/Test/bulk_import.php > /home/sjubedu/public_html/Test/sync_results.log 2>&1 &

```

### **Process Management**

* **Check Sync Progress**: `tail -f /home/sjubedu/public_html/Test/sync_results.log`
* **Kill Active Sync**: `sudo pkill -f bulk_import.php`

---

## ☢️ Emergency Reset (Nuclear Option)

In the event of critical database corruption or a massive security event, use the Emergency Reset tool. This will **TRUNCATE** all traffic and faculty cache tables.

* **URL**: `https://sjub.edu.in/emergency_reset.php?key=SJU_RESET_2026`
* **Action**: Clears `active_visitors`, `banned_ips`, `ip_nicknames`, and all faculty modules (`api`, `phd`, `publication`, `project`, `awards`).
* **Log**: This action is recorded in `purge_history.log`.

---

## 🔍 Troubleshooting & Operational Principles

1. **Fail-Safe Mode**: If `fail_count` increases in the DB, the Linways API is unstable. The system is intentionally serving "Old Data" to protect the frontend.
2. **Performance Priority**: If the server hits an **"F" Grade**, the monitor will prioritize profile loading over traffic tracking.
3. **Permissions**: Ensure the web server has **write** access to `/home/sjubedu/purge_history.log` and the `cache/` directory.

---
# 🎓 St. Joseph's University Portal (SJUB) - Infrastructure & Performance Optimization

![Server Status](https://img.shields.io/website?down_color=red&down_message=offline&label=Server%20Status&up_color=green&up_message=online&url=https%3A%2F%2Fsjub.edu.in%2F)
![PHP Version](https://img.shields.io/badge/PHP-8.x-blue)
![Architecture](https://img.shields.io/badge/Architecture-AWS%20EC2-orange)

This repository documents the architecture, configuration hardening, and performance benchmarking for the **sjub.edu.in** portal. The system is engineered to handle high-concurrency traffic during admission and result cycles.

---

## 🏗 System Architecture

* **Primary Server:** AWS EC2 Instance
* **Operating System:** AlmaLinux 9.x (managed via WHM/cPanel 110+)
* **Hardware Profile:** 4GB RAM / High-Performance SSD
* **DNS & Security:** Cloudflare Proxy (WAF, SSL/TLS 1.3, Brotli Compression)
* **Failover Strategy:** Decoupled Static Failover (Cloudflare Workers + AWS S3)
* **Web Server Stack:** Apache 2.4 (mpm_prefork) + PHP-FPM 8.x

---

## ⚙️ Core Stack Optimization

To resolve early-stage bottlenecks (SSL failures and timeouts), the following stack-wide tuning was implemented:

### 1. PHP-FPM Pool Configuration
Located in: `WHM > MultiPHP Manager > PHP-FPM Settings`

| Setting | Value | Justification |
| :--- | :--- | :--- |
| **pm.max_children** | `30` | Selected to balance CPU and Network I/O for heavy 146KB payloads. |
| **pm.max_requests** | `500` | Prevents memory fragmentation/leaks by recycling processes. |
| **pm.process_idle_timeout** | `10s` | Rapidly reclaims RAM during traffic lulls. |
| **memory_limit** | `128M` | Optimized for a 30-worker pool on 4GB total system RAM. |
| **max_execution_time** | `90s` | Ensures heavy portal scripts complete during high-concurrency spikes. |

### 2. Apache Global Configuration
Located in: `WHM > Apache Configuration > Global Configuration`

* **MaxRequestWorkers:** Increased to **500** (Ensures Apache can queue requests for the PHP backend).
* **ServerLimit:** Set to **500**.
* **KeepAlive:** Enabled (Reduces CPU overhead for repeated student requests).

### 3. Linux Kernel & TCP Tuning
The following sysctl parameters were modified to handle high-concurrency handshakes:

* **net.core.somaxconn:** `4096` (Prevents "SSL Read Failed" errors by expanding the TCP backlog).
* **listen.backlog:** `1024` (PHP-FPM specific queue depth).

---

## 🚀 Performance Benchmarking

We utilized **Apache Benchmark (ab)** to verify system stability.

### **Testing Command Template**
```bash
# General test for dynamic content stability
ab -n 500 -c 30 [https://sjub.edu.in/index2.php](https://sjub.edu.in/index2.php)

## ⚖️ Certified Capacity Baseline

| Endpoint Type | Concurrency | Success Rate | Latency (90%) |
| :--- | :--- | :--- | :--- |
| **Static (Homepage)** | 100 | 100% | <800ms |
| **Dynamic (Portal)** | 30 | 100% | ~2.5s |

**Capacity Verdict:** The server is certified to handle **30 concurrent heavy-database requests** (representing approximately **450–600 active browsing sessions**) without packet loss or SSL termination failures.

---

## 📉 Bottleneck Analysis & Bug Fixes

During the optimization process, the following critical issues were identified and resolved:

* **SSL Read Failed (5):** Caused by TCP backlog exhaustion. Resolved by scaling `somaxconn` to **4096**.
* **AH00161 (MaxRequestWorkers):** Caused by Apache hitting its default worker ceiling. Resolved by increasing the limit to **500**.
* **apr_pollset_poll Timeout:** Triggered by the heavy 146KB payload size of `/index2.php`. Resolved by increasing PHP execution time and capping workers to **30** to avoid network saturation.

---

## 🛡️ Security Hardening

To protect the server during high-visibility periods, the following PHP functions have been strictly disabled:
`exec`, `system`, `passthru`, `shell_exec`, `popen`, `proc_open`

---

## 📝 Future Recommendations

1.  **Gzip/Brotli:** Ensure Gzip is active in WHM "Optimize Website" to shrink the 146KB portal page to ~25KB.
2.  **Object Caching:** Implement **Redis** for session management to further reduce Disk I/O.
3.  **Horizontal Scaling:** If concurrent student traffic exceeds 60, upgrade to an **8GB RAM** instance and scale `pm.max_children` to **60**.

---
Scenario B: Homepage BurstSimulates a massive crowd landing on the site simultaneously.

Bash

ab -n 1000 -c 100 [https://sjub.edu.in/](https://sjub.edu.in/)

Real-time Monitoring
Run this via SSH during any test to monitor the PHP-FPM memory footprint:
Bash





---

# 🚀 SJU Infrastructure Load Testing & Performance Report

![banner](https://img.shields.io/badge/SJU-Infrastructure%20Test-blue)
![Apache](https://img.shields.io/badge/WebServer-Apache-red)
![PHP](https://img.shields.io/badge/PHP-FPM-purple)
![Database](https://img.shields.io/badge/Database-MySQL-orange)
![Status](https://img.shields.io/badge/Load%20Test-Passed-brightgreen)
![Website](https://img.shields.io/website?url=https%3A%2F%2Fsju.edu.in%2F)


Performance validation and stress testing report for

**https://sjub.edu.in**

This project documents load testing, server limits, bottlenecks, and recovery procedures for the production infrastructure.

---

# 🖼 System Architecture

```mermaid
flowchart TD

A[Internet Users] --> B[Apache Web Server]
B --> C[PHP FPM Workers]
C --> D[MySQL Database]

B --> E[Static Content]
C --> F[Dynamic Portal Requests]
````

---

# 🧪 Load Testing Scenario

## Homepage Burst Test

Simulates hundreds of users landing on the homepage simultaneously.

```bash
ab -n 1000 -c 100 https://sjub.edu.in/
```

| Parameter | Description              |
| --------- | ------------------------ |
| `-n 1000` | Total number of requests |
| `-c 100`  | Concurrent users         |

This replicates situations like:

* admission results
* event announcements
* viral social media traffic
* peak student portal access

---

# 📊 Infrastructure Capacity Baseline

| Endpoint          | Concurrency | Success Rate | Latency  |
| ----------------- | ----------- | ------------ | -------- |
| Homepage (Static) | 100         | 100%         | < 800 ms |
| Portal (Dynamic)  | 30          | 100%         | ~2.5 s   |

### Certified Capacity

Infrastructure safely supports:

**30 heavy database requests concurrently**

Equivalent to roughly:

**450–600 active users browsing simultaneously**

---

# 📉 ApacheBench Performance Example

Typical output metrics.

| Metric              | Value       |
| ------------------- | ----------- |
| Requests per second | ~120        |
| Time per request    | ~820 ms     |
| Failed requests     | 0           |
| Transfer rate       | ~1.8 MB/sec |

---

# 📈 Load Test Performance Chart

Example representation of concurrency vs latency.

```mermaid
xychart-beta
title "Server Performance"
x-axis [10,20,30,50,100]
y-axis "Latency (ms)"
line [200,350,600,1200,2400]
```

Interpretation:

* performance stable up to **30 dynamic requests**
* latency increases sharply beyond this level

---

# 🖥 Real Time Monitoring

Monitor PHP worker memory usage during load tests.

```bash
watch -n 1 "ps aux | grep php-fpm | awk '{sum+=\$6} END {print sum/1024 \" MB\"}'"
```

Shows total PHP-FPM memory consumption every second.

---

# 🔍 Monitoring Flow

```mermaid
flowchart LR

A[Load Test Tool] --> B[Apache]
B --> C[PHP FPM]
C --> D[MySQL]

B --> E[System Metrics]
C --> F[Memory Usage]
D --> G[Database Queries]
```

---

# 🚨 Emergency Recovery Commands

If the server becomes unresponsive due to traffic spikes.

### Soft Reset

```bash
/scripts/restartsrv_httpd
/scripts/restartsrv_phpfpm
```

---

### Restart Database

```bash
/scripts/restartsrv_mysql
```

---

### Force Reset PHP Workers

```bash
killall -9 php-fpm && /scripts/restartsrv_phpfpm
```

---

# 🧠 Bottleneck Analysis

## SSL Read Failed

Cause
TCP backlog exhaustion.

Fix

```
net.core.somaxconn = 4096
```

---

## Apache MaxRequestWorkers

Cause
Apache worker pool exhausted.

Fix

```
MaxRequestWorkers 500
```

---

## apr_pollset_poll Timeout

Cause
Large `/index2.php` payload (~146 KB).

Fix

• increased execution timeout
• capped PHP worker pool to **30**

---

# 🛡 Security Hardening

The following PHP functions are disabled to prevent remote code execution.

```
exec
system
passthru
shell_exec
popen
proc_open
```

---

# 📊 Performance Summary

| Metric                   | Result    |
| ------------------------ | --------- |
| Static page concurrency  | 100 users |
| Dynamic page concurrency | 30 users  |
| Success rate             | 100%      |
| Max latency              | 2.5 s     |
| Packet loss              | None      |

---

# 🔮 Future Improvements

Recommended scaling improvements.

* Redis caching layer
* Nginx reverse proxy
* AWS Application Load Balancer
* Prometheus monitoring
* Grafana dashboards
* Horizontal scaling with Auto Scaling Groups

---

# 👨‍💻 Maintainer

**Jogith Biju**
Web Developer

LinkedIn
[https://www.linkedin.com/in/jogith-biju/](https://www.linkedin.com/in/jogith-biju/)

---

# ⭐ Status

Infrastructure tested and validated for high traffic bursts.

```

---

If you want, I can also show you **3 powerful additions** that will make this repo look like a **real DevOps / SRE portfolio project**:

1️⃣ **Automatic load testing pipeline using GitHub Actions**  
2️⃣ **Real ApacheBench graph generation from test logs**  
3️⃣ **Live monitoring dashboard using Grafana**

These make the repo look **10× more impressive for recruiters and engineers**.
```

## 🛡️ Linways-Grade Security Hardening

**Objective:** Transition the `sjub.edu.in` security posture from "standard" to "enterprise-grade," matching the protection levels used by major ERP platforms like Linways.

### 1. Strategic Policy Shift
* **Enforcement over Monitoring:** Migrated the Content Security Policy (CSP) from `Report-Only` to a live, active block. The server now actively terminates unauthorized scripts rather than just logging the attempts.
* **Whitelisted Tech Stack:** Precision-engineered the policy to allow high-performance tools while maintaining a "Zero-Trust" boundary:
    * **Marketing & Analytics:** Google Analytics (GA4) and Facebook Pixel.
    * **Verified CDNs:** Bootstrap (jsDelivr), Cloudflare (cdnjs), and Google Fonts.
    * **Functional Utilities:** Support for QR Code generation (via `blob:` URIs) and Print JS libraries.

### 2. Process Isolation & Privacy
Implemented advanced isolation headers to protect student and faculty session data from browser-level vulnerabilities (e.g., Spectre/Meltdown):
* **COOP/COEP:** Isolates the browser process to ensure malicious tabs cannot "inspect" SJU session memory.
* **CORP:** Prevents third-party sites from hotlinking or "stealing" SJU assets and images.
* **Hardware Lockdown:** A strict `Permissions-Policy` explicitly disables the camera, microphone, and geolocation at the browser level unless required.

### 3. The "Zero-Trust" Header Stack
| Header | Purpose | Status |
| :--- | :--- | :--- |
| **HSTS** | Forces 1-year HTTPS requirement; prevents protocol downgrades. | **Active** |
| **`object-src`** | Disables legacy plugins (Flash/Java) to close common entry points. | **None** |
| **`form-action`** | Ensures sensitive form data is only submitted to verified SJU endpoints. | **Restricted** |
| **X-Content-Type** | Prevents MIME-sniffing attacks. | **Nosniff** |
| **X-Frame-Options** | Prevents Clickjacking by disallowing unauthorized iframes. | **SameOrigin** |

### 4. Stealth Monitoring & Data Protection
* **Private Audit Log:** Integrated a secure collector (`csp-report.php`) that logs blocked threats to a hidden system file (`csp_violations.log`).
* **Access Control:** Hardened the file system via `.htaccess` to ensure configuration files (`config.php`, `i_db.php`) and security logs are strictly inaccessible (403 Forbidden) to the public.

Here is a professionally structured `README.md` file based on your `.htaccess` configuration. This is designed to help your developer understand the server environment and security protocols at a glance.

---

# Server Configuration & Security Manifesto

This repository contains the core `.htaccess` configuration for the **SJUB** web server. It handles PHP environment variables, security hardening (CSP), and performance headers.

## 🛠 PHP Environment (`ea-php82`)

The server is currently configured for **Development Mode**.

* **Error Reporting**: `display_errors` is currently **ON**.
* **Memory Limit**: `256M`
* **Execution Time**: `180s`
* **Upload Limits**:
* `upload_max_filesize`: **2MB** (Note: Increase this if student document uploads are required).
* `post_max_size`: **8MB**



## 🛡 Security Hardening

### 1. Content Security Policy (CSP)

We implement a strict CSP to prevent XSS and unauthorized data injection.

* **Scripts**: Trusted sources include Google Analytics, Facebook, WhatsApp, SoundCloud, and jsDelivr.
* **Images**: Explicitly allows `'self'` and our **AWS S3 Bucket** (`sjub.s3.ap-south-1.amazonaws.com`).
* **Frame Ancestors**: Restricted to `'self'` and `https://sjub.edu.in`.

### 2. Protocol & Header Protection

* **HSTS**: Forced HTTPS via `Strict-Transport-Security` for 1 year.
* **Sniff Protection**: `X-Content-Type-Options: nosniff` enabled.
* **Directory Privacy**: `Options -Indexes` is active to prevent directory browsing.

### 3. Access Control

Access is strictly **denied** for the following:

* **Sensitive Extensions**: `.log`, `.ini`, `.env`, `.sql`, `.bak`.
* **Core Files**: `config.php`, `i_db.php`.
* **Hidden Files**: Any file or folder starting with a dot (e.g., `.git`, `.env`).
* **Benchmarking Tools**: Blocked `ApacheBench` user agents to mitigate basic DoS attempts.

## 🚀 Caching Strategy

The configuration includes a **Dual-Mode** caching block:

### **Current Status: Development Mode**

* **Cache-Control**: `no-cache, no-store, must-revalidate`
* **Goal**: Ensures all JavaScript (`mainv1.js`) and CSS changes are visible immediately without browser caching interference.

### **Production Mode (Pending)**

* Once the site is stable, the assets block should be toggled to `max-age=31536000` (1 year) to improve PageSpeed scores and reduce server load.

## 📂 Custom Error Handling

* **403 Forbidden**: Returns a lightweight "Not Authorized" string.
* **404 Not Found**: All missing `.php` requests are routed to `/404.php`.

---

### ⚠️ Note for Developers

When adding new third-party integrations (trackers, chat widgets, or external APIs), you **must** update the `Content-Security-Policy` header in `.htaccess`. Failure to do so will result in the browser blocking the external resource.


Perfect. Here is your manual backup workflow, structured in a clean, professional `README.md` format. This covers every step from creation to cleanup, specifically for your manual process.

---

# 📦 SJU Server: Manual Backup & S3 Migration
**Location:** `/backup/`  
**Region:** `ap-south-1` (Mumbai)  
**Target:** `s3://sju-backups-storage/`

---

## 🛠 Step 1: Create the Backup Archive
Use the cPanel internal script to package the `sjubedu` account. This handles the website files, databases, and emails.

```bash
/usr/local/cpanel/scripts/pkgacct sjubedu /backup/2026-03-17/accounts/
```

---

## 🔍 Step 2: Verify the File
Before uploading, confirm the file exists and check its size (expected ~2.3GB).

```bash
ls -lh /backup/2026-03-17/accounts/sjubedu.tar.gz
```

---

## ☁️ Step 3: Manual Upload to AWS S3
Push the local archive to your S3 bucket in Mumbai. 

> **Note:** Replace `REDACTED` with your actual AWS credentials.

```bash
sudo AWS_ACCESS_KEY_ID="AKIA4SYAMQP74NUJSHHL" AWS_SECRET_ACCESS_KEY="5xWAdlHAqEIVs/pmBlae35bj0K9sZCzNsTEUOIRY" /usr/local/bin/aws s3 cp /backup/2026-03-17/accounts/sjubedu.tar.gz s3://sju-backups-storage/2026-03-17/accounts/sjubedu.tar.gz --region ap-south-1
```

---

## 🗑 Step 4: Final Verification & Cleanup
Once the AWS CLI shows **"upload: ... to s3://..."**, you must delete the local copy to save server disk space for student logins.

### 1. Confirm File is in S3
```bash
/usr/local/bin/aws s3 ls s3://sju-backups-storage/2026-03-17/accounts/
```

### 2. Remove the Local Backup Folder
```bash
rm -rf /backup/2026-03-17/
```

### 3. Check Disk Usage
```bash
df -h /backup
```

---

## 📌 Maintenance Notes
* **Daily Goal:** Keep the `/backup` folder empty after every manual push to avoid "Disk Full" errors during high-traffic academic periods.
* **Manual Control:** This process is used instead of the automated WHM system to ensure immediate verification of each step.

---

### 🌙 11:40 PM Update
You’ve got the full plan now. Since you are doing this manually, you have total control over that 2.3GB of space. 

### Next way rouubd using terminal
tar -cf - /home/sjubedu/public_html | AWS_ACCESS_KEY_ID='AKIA4SYAMQP74NUJSHHL' AWS_SECRET_ACCESS_KEY='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' /usr/local/bin/aws s3 cp - s3://sju-backups-storage/stream-backup/SJU_FULL_$(date +%F).tar --region ap-south-1

[ec2-user@13-127-172-129 sjubedu]$ # 1. Clear the old log

sudo rm /home/sjubedu/cron_debug.log



# 2. Run the command directly (Replace YOUR_KEYS with real ones)

sudo tar -cf - /home/sjubedu/ | AWS_ACCESS_KEY_ID="AKIA4SYAMQP74NUJSHHL" AWS_SECRET_ACCESS_KEY="5xWAdlHAqEIVs/pmBlae35bj0K9sZCzNsTEUOIRY" aws s3 cp - s3://sju-backups-storage/full-backup/SJU_TEST.tar --region ap-south-1

sudo nohup sh -c 'tar -cf - /home/sjubedu/ | aws s3 cp - s3://sju-backups-storage/full-backup/SJU_FINAL.tar' > backup.log 2>&1 &
## how to verify
AWS_ACCESS_KEY_ID='AKIA4SYAMQP74NUJSHHL' AWS_SECRET_ACCESS_KEY='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' /usr/local/bin/aws s3 ls s3://sju-backups-storage/stream-backup/ --region ap-south-1 --human-readable


Here is a formatted `README.md` that you can save in your `/home/sjubedu/` directory. This will help you (or anyone else managing the university server) understand exactly why the schedule was chosen and what each task does.

---

```markdown
# SJU Server Maintenance & Backup Schedule (sjub.edu.in)

This document outlines the automated Cron Jobs for the university infrastructure. All tasks are scheduled during off-peak hours to ensure maximum performance for students and faculty.

---

## 🕒 Current Execution Schedule

| Time | Task / Command | Priority | Notes / Strategy |
| :--- | :--- | :--- | :--- |
| **01:00 AM** | `cron_update_all.php` | Medium | Initial daily sync and data update. |
| **01:45 AM** | **SQL Database Dump** | **CRITICAL** | Streams compressed `.sql.gz` to AWS S3 (Mumbai). Scheduled before heavy file transfers. |
| **02:01 AM** | **4.8 GiB File Stream** | **CRITICAL** | Streams `public_html` to AWS S3. Heaviest bandwidth task. |
| **03:00 AM** | `master_sync.php` | High | Final daily master synchronization. |
| **Monthly** | `rotate-logs.php` | Maintenance | Clears old log files to prevent disk space exhaustion. |

---

## 🛡️ Backup Infrastructure Details

### 1. File Backups (AWS S3)
- **Destination:** `s3://sju-backups-storage/stream-backup/`
- **Method:** Streaming `tar` directly to AWS CLI to bypass local disk limits.
- **Region:** `ap-south-1` (Mumbai) for low latency.

### 2. Database Backups (AWS S3)
- **Destination:** `s3://sju-backups-storage/db-backups/`
- **Method:** `mysqldump` piped through `gzip` for maximum compression and cost savings.

### 3. Cost & Retention
- **Lifecycle Policy:** All backups are subject to a **30-day auto-deletion policy** in S3 to manage university storage costs.
- **Monitoring:** Logs for these tasks are stored in:
  - `/home/sjubedu/cron_debug.log` (File Backups)
  - `/home/sjubedu/sql_cron_debug.log` (Database Backups)

---

## ⚠️ Emergency Procedures

**To stop all active backup streams immediately:**
```bash
pkill -u sjubedu -f "tar|aws|mysqldump"
```

**To verify a backup is currently running:**
```bash
ps aux | grep -E 'tar|aws|mysqldump'
```

---
*Last Updated: March 18, 2026*
```

---

---

# 🌐 Public Portal — Frontend Updates (May 2026)

This section documents all recent design and functionality upgrades made to the public-facing pages of `sjubedu/public_html/`.

---

## 📰 1. IQAC Newsletter Page
**File:** `about/iqac/sju-iqac-newsletter.php`

### Changes
- **Redesigned cards** using `.nl-card` component with SJU blue/gold colours and hover lift effect.
- **Year-wise filter bar** (All / 2025 / 2024 / 2023 / 2022) with live JS filtering and a dynamic count badge.
- **New entry added:** Josephite Newsletter Volume 19 Issue 1 (2025) from AWS S3.
- All entries put in **reverse-chronological order** (newest first).
- "New" amber badge on the latest issue.

### Technical Notes
- Filter uses `data-year` attributes on each card; JS iterates `querySelectorAll('.nl-card')` on button click.
- Count badge (`id="nlCount"`) updates live.
- PDF links point to `sjudata.s3.ap-south-1.amazonaws.com/IQAC/Newsletter/`.

---

## 📊 2. IQAC NIRF Page
**File:** `about/iqac/sju-iqac-nirf.php`

### Changes
- Same card design and year-filter pattern as the Newsletter page.
- **Archive section removed** — only active reports shown (NIRF 2026, 2025, 2024).
- Year filter: All / 2026 / 2025 / 2024. Count badge shows "3 Reports".
- "New" badge on NIRF 2026.
- Public Consultation Notice alert preserved at top.

---

## 🗂️ 3. Shortlisted Candidates Page
**File:** `admissions/shortlisted-candidates.php`

### Design Changes
- `.calendar-card` overridden with SJU **gold/blue** scheme:
  - Blue left border (`#1a3c6e`) that turns gold (`#c9a227`) on hover.
  - Gold gradient icon box.
  - Blue gradient "View Document" button.
- Section header (`#sc-header`) with document count chip and integrated search bar.

### Search — Fuzzy Matching
Typing partial or misspelled queries still finds the right results:
- **Subsequence algorithm** — "pysics" matches "Physics", "Elecronics" matches "Electronics".
- Each query word matched independently; short words (< 4 chars) require exact match to avoid false positives.

### Search — Google-style Autocomplete
Dropdown suggestions appear as the user types:
- **Authoritative programme list** sourced directly from `all-programmes.php` (65+ programmes) — no regex scraping, no duplicates.
- **All 12 months** (January–December) as static date suggestions, so "July" is always suggested even before any July card exists.
- **Years 2020–2099** as static year suggestions.
- Actual interview dates extracted dynamically from card titles at runtime.
- Matched text **bolded** in suggestion (like Google).
- Icons distinguish type: 📅 date · 🎓 subject · 🏆 programme.
- Keyboard navigation: ↑ ↓ arrows, Enter to select, Escape to close.

### Performance — Search Caching
- Card `textContent` extracted **once on load** into `cardTexts[]` array.
- Filter results memoised per query string in `filterCache{}` object.
- Repeated or backspaced queries reuse cached results — no re-scanning 443 cards.

### Template Comment
A copy-paste HTML template is commented just above the first active card for easy addition of new entries:
```html
<!-- TEMPLATE — copy this block to add a new entry
<div class="calendar-card d-flex flex-column flex-md-row ...">
  <h5 class="calendar-title">[PROGRAMME NAME] interview on [DATE]</h5>
  <a href="[S3 PDF URL]" ...>View Document →</a>
</div>
-->
```

### Bootstrap `display: flex !important` Fix
Bootstrap's `.d-flex` class sets `display: flex !important` which overrides plain inline `style="display: none"`. Fix uses:
```javascript
card.style.setProperty('display', 'none', 'important'); // hide
card.style.removeProperty('display');                   // show
```

---

## 🌳 4. Campus Trees Page
**File:** `tree.php`

### Design Redesign
- Full nature-themed layout replacing the old plain grid.
- **Stats chips** at top: 26 Species · 15 Families · 26 Locations.
- **Card grid** (`col-lg-3 col-md-4 col-sm-6`) with hover lift, green border, and "Explore →" row.
- Each card shows: tree number badge, common name, scientific name (italic), Kannada name, family tag.

### Card Thumbnail Images
- Images loaded **dynamically via JS** from AWS S3 (`sjudata.s3.ap-south-1.amazonaws.com/Trees/SJU+Trees+Image/`).
- A `thumbs` lookup map (tree index → S3 URL) drives `img.onload` / `img.onerror` logic:
  - On load → show photo, hide fallback icon.
  - On error → show green tree icon fallback.
- Tree index used directly (`forEach(item, idx)`) instead of parsing `data-bs-target`, eliminating a TypeError crash risk.

### Modal Carousel Images
- All 26 modal carousels updated with real S3 URLs — **zero `YOUR-S3-BUCKET` placeholders remaining**.
- Trees 1–3, 6–7: 5 images each. Trees 4, 8–9: 3–4 images. Trees 10–26: 1 image each.

### QR Code Fix
- Removed `src=""` from all 26 QR `<img>` tags (was causing a broken-image request to the current page).
- QR URL now set **lazily** on Bootstrap `show.bs.collapse` event — only fetched when user clicks "Show QR Code".
- QR service: `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=[page-url]?tree=[n]`

### Live Search
- `<input id="treeSearch">` filters cards by `data-search` attribute (contains common name, scientific name, Kannada name, family).
- Count label (`id="treeCount"`) and no-results div update live.
- Deep-link support: `?tree=5` in URL auto-opens modal 5 on page load.

---

## 🎨 SJU Brand Colours Reference

| Use | Hex |
| :--- | :--- |
| Primary blue (dark) | `#1a3c6e` |
| Primary blue (light) | `#2563b0` |
| Gold (dark) | `#b8922a` |
| Gold (light) | `#c9a227` |

These are applied consistently across all four updated pages.

---

## 📄 5. Bulletin PDF Viewer
**File:** `bulletin/bulletin-view.php`

### What it does
A universal, publication-agnostic PDF viewer used by all student publications (The Beacon, Communique, Photo Beacon). Loaded by passing `?pub=beacon&file=filename.pdf` in the URL.

### Publication Registry
Defined in PHP at the top of the file — no other file needs editing to add a new publication:
```php
$publications = [
    'beacon'     => ['label' => 'The Beacon',   's3_folder' => 'Bulletin/Beacon%202025-2026/', ...],
    'communique' => ['label' => 'Communique',   's3_folder' => 'Bulletin/Communique/', ...],
    'photobeacon'=> ['label' => 'Photo Beacon', 's3_folder' => 'Bulletin/Photo%20Beacon/', ...],
];
```

### Security
- `pub` key validated against the registry (`array_key_exists`) — unknown keys redirect to `/bulletin/sjubeacon`.
- `file` parameter sanitised: no `/` or `..` (path traversal blocked), must match a publication's `prefixes` array.
- dSpace archive URLs allowed only for Beacon 2023 archive (`src=dspace`).

### Display Date Parsing
Auto-generates a human-readable date from the filename:
- `DD-MM-YYYY` format (Beacon) → e.g. "14 March 2026"
- Month-name + year format (Communique) → e.g. "April 2025"

### Adding a New Publication
Add one entry to `$publications[]` in `bulletin-view.php`. Fields:

| Key | Description |
| :--- | :--- |
| `label` | Display name shown in header and breadcrumb |
| `back_url` | URL of the publication's index page |
| `s3_folder` | S3 path prefix (URL-encoded spaces as `%20`) |
| `color` | Hex colour for the top viewer bar |
| `icon` | Font Awesome class for the bar icon |
| `bg` | Background colour of the PDF iframe area |
| `prefixes` | Allowed filename prefixes (empty array = any file) |

---

## 🤖 6. AI & SEO Files

### `llms.txt`
**File:** `public_html/llms.txt`

Standard `llms.txt` file (like `robots.txt` but for LLMs/AI crawlers). Provides high-fidelity direct links to all academic departments, admissions, research, and services for AI indexing and discovery.


### `sitemap.xml`
**File:** `public_html/sitemap.xml`

Standard XML sitemap (601 URLs). All pages include `<lastmod>`, `<changefreq>`, and `<priority>`.


---

*Last Updated: May 2026*

---

# ⚙️ 7. `.htaccess` — Server Configuration Reference

**File:** `public_html/.htaccess` (396 lines)

This file is the single control point for PHP runtime, caching, URL routing, security headers, WAF rules, redirects, and gone-page declarations. Every section is explained below.

---

## 7.1 PHP INI Directives

Managed by cPanel's MultiPHP INI Editor. Applied to both `php8_module` and `lsapi_module` handlers.

| Directive | Value | Why |
| :--- | :--- | :--- |
| `display_errors` | `Off` | Hides stack traces from public users (production safe) |
| `max_execution_time` | `180s` | Allows heavy sync scripts (`master_sync.php`, bulk generators) to complete |
| `max_input_time` | `180s` | Matches execution time for long POST payloads |
| `max_input_vars` | `7000` | Handles large Linways API form submissions without truncation |
| `memory_limit` | `256M` | Sufficient for 30-worker pool on 4 GB RAM |
| `post_max_size` | `12M` (php8) / `8M` (lsapi) | Accommodates document uploads |
| `upload_max_filesize` | `20M` | Allows faculty PDF/image uploads |
| `session.gc_maxlifetime` | `1440s` | 24-minute sessions (standard university portal) |
| `zlib.output_compression` | `Off` | Compression handled by Cloudflare Brotli — avoids double-compression |

---

## 7.2 Caching Strategy

Two named modes are present in the file; only one is active at a time.

| Mode | Selector | Behaviour |
| :--- | :--- | :--- |
| **Development** (commented out) | `.html`, `.php`, `.js`, `.css` | `no-cache, no-store, must-revalidate` — every request hits the server |
| **Production** (active) | `.html`, `.php` | `no-cache, must-revalidate` — browser revalidates with server each visit |
| **Production** (active) | `.js`, `.css`, images, fonts | `max-age=31536000, public, immutable` — cached for 1 year in browser |

The 1-year immutable cache on assets means JS/CSS updates **must** use filename versioning (e.g. `mainv2.js`) to bust the cache for returning users.

---

## 7.3 Global Discovery Headers

These two headers are set unconditionally on every response:

```apache
Header set X-Robots-Tag "noarchive, index, follow"
Header set Link "<https://sju.edu.in/llms.txt>; rel='llms-txt'"
```

- **`X-Robots-Tag: noarchive, index, follow`** — Pages are indexed and links followed, but Google/Bing will not show a cached copy of the page in search results. Prevents outdated content appearing in "Cached" links.
- **`Link: rel='llms-txt'`** — Advertises the `llms.txt` discovery file to AI crawlers (same concept as `robots.txt`). Lets Claude, ChatGPT, Perplexity etc. find all department URLs without scraping.

---

## 7.4 URL Rewriting — Clean URLs

Strips `.php` extensions from public URLs (`/about` instead of `/about.php`).

**Step 1 — External 301 redirect** (browser sees clean URL):
- Fires only if the request contains `.php` in the path.
- AJAX endpoints are explicitly excluded so they continue to work with their `.php` extension:
  `fee_fetch.php`, `news.php`, `publications.php`, `projects.php`, `patents.php`, `book-chapters.php`, `books-published.php`, `consultancy.php`, `events-organised.php`, `popular-media.php`

**Step 2 — Internal rewrite** (server silently loads the `.php` file):
- Fires only if no matching real file or directory exists at the clean path.
- Appends `.php` and serves the file transparently.

---

## 7.5 Content Security Policy (CSP)

The CSP is the most important security header — it tells the browser exactly which external sources are allowed to load scripts, styles, images, fonts, frames, and API calls. Anything not listed is blocked.

### Version History (3 commented + 1 active)

The file contains 4 CSP versions; only the last one is active:

| # | Label | Status | Key difference |
| :--- | :--- | :--- | :--- |
| 1 | YouTube & Climate Clock | Commented | Broader `https:` wildcards; `unsafe-eval` allowed; Facebook frames |
| 2 | SJU Master (Maps, Charts, GeoJS) | Commented | Added `cdn.jsdelivr.net`, `get.geojs.io`, SoundCloud frame |
| 3 | SJU Monitor (Maps, Health Checks) | Commented | Tighter domain whitelist; no `unsafe-eval`; S3 buckets explicit |
| 4 | **Active CSP** | **Live** | GA4 pixels, SoundCloud widget, dSpace PDF viewer, DoubleClick |

### Active CSP — Per-Directive Breakdown

```apache
Header always set Content-Security-Policy "upgrade-insecure-requests; \
    frame-ancestors ...; default-src ...; script-src ...; ..."
```

| Directive | What it controls | Allowed sources & why |
| :--- | :--- | :--- |
| `upgrade-insecure-requests` | Rewrites `http://` sub-resources to `https://` automatically | Prevents mixed-content warnings from old hardcoded links |
| `frame-ancestors` | Which sites can embed SJU pages in an `<iframe>` | `'self'` + `*.sju.edu.in` only — prevents Clickjacking from external sites |
| `default-src` | Fallback for any directive not explicitly set | `'self'` + `*.sju.edu.in` — everything defaults to SJU domains |
| `script-src` | JavaScript file sources | `'self'`, `'unsafe-inline'` (inline `<script>` tags used throughout the site), `unpkg.com` (Leaflet maps), `cdn.jsdelivr.net` (Bootstrap), `cdnjs.cloudflare.com` (FontAwesome/jQuery), `googletagmanager.com` + `google-analytics.com` + `ssl.google-analytics.com` (GA4), `static.cloudflareinsights.com` (Cloudflare Web Analytics), `w.soundcloud.com` (SoundCloud widget JS) |
| `style-src` | CSS sources | `'self'`, `'unsafe-inline'` (Bootstrap utilities use inline styles), `unpkg.com`, `cdn.jsdelivr.net`, `fonts.googleapis.com` (Google Fonts stylesheet) |
| `img-src` | Image sources | `'self'`, `data:` (base64 images), `blob:` (dynamically generated images like QR codes), `*.sju.edu.in`, `sjub.s3.ap-south-1.amazonaws.com` + `sjudata.s3.ap-south-1.amazonaws.com` (both S3 buckets), `google-analytics.com` + `googletagmanager.com` (GA4 tracking pixels), `*.sndcdn.com` (SoundCloud artwork thumbnails), `*.tile.openstreetmap.org` + `unpkg.com` + `cdnjs.cloudflare.com` (Leaflet map tiles) |
| `font-src` | Web font sources | `fonts.gstatic.com` (Google Fonts files), `cdnjs.cloudflare.com` + `cdn.jsdelivr.net` (FontAwesome fonts) |
| `connect-src` | XHR / `fetch()` / WebSocket targets | `'self'`, `*.sju.edu.in`, `ip-api.com` (Master Monitor's IP geolocation lookup), `get.geojs.io` (alternative geo API), `*.tile.openstreetmap.org` (map tile XHR), `cdn.jsdelivr.net`, both S3 buckets, full `google-analytics.com` + `analytics.google.com` family (GA4 beacon), `api-widget.soundcloud.com` (SoundCloud player API) |
| `frame-src` | `<iframe>` sources | `'self'`, `blob:` + `data:` (PDF blob iframes in bulletin viewer), `www.youtube.com` (YouTube embeds on department pages), `*.google.com` (Google Maps), `td.doubleclick.net` (Google remarketing pixel), `w.soundcloud.com` (SoundCloud embedded player), `sjudata.s3.ap-south-1.amazonaws.com` (direct S3 PDF iframes), `dspace.sju.edu.in` (SJU's own DSpace institutional repository — used by the bulletin PDF viewer for Beacon 2023 archive) |
| `object-src` | Flash / Java plugins | `'none'` — completely disabled; no legacy plugin support |
| `base-uri` | `<base href>` tag | `'self'` only — prevents attackers from changing the page's base URL |
| `form-action` | Where `<form>` data can be submitted | `'self'` only — all form submissions must go to SJU endpoints |
| `report-uri` | Where CSP violation reports are sent | `https://www.sju.edu.in/Test/csp-report.php` — violations logged to `csp_violations.log` |

### Why `'unsafe-inline'` is necessary

All SJU pages use inline `<script>` and `<style>` blocks heavily (Bootstrap, custom JS). Moving all JS to external files would allow removing `'unsafe-inline'` but would require a significant refactor. The current CSP mitigates XSS risk through `frame-ancestors` restrictions and `form-action: 'self'`.

---

## 7.6 Other Security Headers

Set in the same `<IfModule mod_headers.c>` block as the CSP:

| Header | Value | Purpose |
| :--- | :--- | :--- |
| `X-Content-Type-Options` | `nosniff` | Prevents browsers from guessing content type — stops MIME-sniffing attacks |
| `Referrer-Policy` | `no-referrer-when-downgrade` | Sends full referrer to same-origin and HTTPS destinations; hides it on HTTP |
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains; preload` | Forces HTTPS for 1 year across all subdomains; eligible for HSTS preload list |
| `Permissions-Policy` | `compute-pressure=(), camera=(), microphone=(), geolocation=()` | Disables access to hardware sensors at the browser level — no page can request camera/mic/location unless removed |
| `X-Permitted-Cross-Domain-Policies` | `none` | Blocks Flash/Silverlight cross-domain policy files (legacy attack vector) |
| `Cross-Origin-Opener-Policy` | `same-origin-allow-popups` | Isolates the browsing context; allows OAuth/payment popups but blocks cross-origin window inspection (Spectre mitigation) |
| `Cross-Origin-Resource-Policy` | `cross-origin` | Allows SJU assets (images, scripts) to be loaded by cross-origin pages — needed because S3-hosted assets are embedded on department pages |

---

## 7.7 Custom Error Pages

```apache
ErrorDocument 403 /403.php
ErrorDocument 404 /404.php
```

- **403** — Served when WAF or file-blocking rules deny a request.
- **404** — All missing `.php` requests route here; provides a branded "page not found" experience.

---

## 7.8 Sensitive File Blocking

Two layers of protection:

**Layer 1 — Extension + filename blocklist:**
Denies any request matching these extensions or exact filenames:
`.log`, `.ini`, `.env`, `.sql`, `.bak`, `.bk`, `.old`, `.backup`, `.tmp`, `.swp`, `.gz`, `.tar`, `.zip`, `.rar`, `.7z`, `.pem`, `.key`, `.crt`, `.p12`, `.pfx`, `.DS_Store`, `config.php`, `i_db.php`, `csp_violations.log`, `composer.json`, `composer.lock`, `package.json`, `package-lock.json`, `yarn.lock`

**Layer 2 — Hidden file protection:**
Any file or directory beginning with a `.` returns 403 Forbidden. This protects `.git`, `.env`, `.htaccess` itself, and any dotfiles from being read via HTTP.

---

## 7.9 Lightweight WAF (Web Application Firewall)

8 rule groups that return 403 Forbidden:

| # | Rule | What it blocks |
| :--- | :--- | :--- |
| 1 | Bad HTTP methods | `TRACE` and `TRACK` requests (used for cross-site tracing attacks) |
| 2 | Malicious user agents | `libwww-perl`, `curl`, `wget`, `python`, `nikto`, `sqlmap`, `acunetix`, `w3af`, `appscan`, `havij`, `ApacheBench` |
| 3 | SQL injection / XSS in query strings | `UNION SELECT`, `INSERT`, `UPDATE`, `DELETE`, `DROP`, `<script>`, `javascript:`, `base64_encode`, `boot.ini`, `etc/passwd` |
| 4 | Path traversal | `../`, `%2e%2e%2f`, and URL-encoded variants |
| 5 | Remote file inclusion | Query strings containing `http://`, `https://`, `ftp://`, or `php://` |
| 6 | Shell injection | Semicolons followed by `wget`, `curl`, `bash`, `exec`, `system`, `passthru` |
| 7 | PHP execution in upload dirs | Any `.php`, `.phtml`, `.pl`, `.py`, `.cgi`, `.sh` file under `uploads/` or `assets/img/` |
| 8 | WordPress probe paths | `wp-login.php`, `wp-admin/`, `xmlrpc.php`, `wp-config.php` (bots scan all sites for these) |

---

## 7.10 HTTPS + WWW Enforcement

Single redirect hop combines both HTTPS and WWW:

```apache
RewriteCond %{HTTPS} off [OR]
RewriteCond %{HTTP_HOST} ^sju\.edu\.in [NC]
RewriteRule ^(.*)$ https://www.sju.edu.in/$1 [L,R=301]
```

- `http://sju.edu.in/about` → `https://www.sju.edu.in/about`
- `http://www.sju.edu.in/about` → `https://www.sju.edu.in/about`
- `https://sju.edu.in/about` → `https://www.sju.edu.in/about`

A commented-out two-hop version is preserved for reference but not active.

---

## 7.11 301 Permanent Redirects

| Old URL | Redirects to | Reason |
| :--- | :--- | :--- |
| `/faq` | `/faq.php` | Clean URL to PHP |
| `/admissions` | `/admissions/admissions.php` | Top-level to nested page |
| `/career` | `/whysju/career.php` | Restructured URL |
| `/candidateshortlisted` | `/admissions/shortlisted-candidates.php` | Old short URL → new page |
| `/library` | `/library/library.php` | Nested page |
| `/examination` | `/examination/examination.php` | Nested page |
| `/placements` | `/placements/about-placements.php` | Nested page |
| `/vision-and-mission` | `/about/vision-and-mission.php` | Restructured |
| `/all-courses` | `/admissions/all-programmes` | Renamed section |
| `/departments/.../Communication` | Full dept URL | Old dept URL → new school URL |
| `/courses/.../master-of-science-in-computer-science` | CS dept page | Old course URL → dept page |
| `/school-of-life-sciences/.../enviornmental...` | Corrected spelling URL | Typo fix (enviornmental → environmental) |
| Various `/announcements/view-pdf/...` and gallery pages | `https://sju.edu.in/` | Content moved to announcements page |
| `/services/sju-document-verification` | `https://www.sju.edu.in/` | Service retired |
| `/uploads/cmsmenu/` | `https://www.sju.edu.in/` | Old CMS path blocked |

---

## 7.12 410 Gone — Removed Pages

50+ old announcement PDFs and gallery pages return HTTP `410 Gone` (not `404`). This is deliberate: `410` tells search engines the page is **permanently removed** and to drop it from the index immediately, whereas `404` suggests a temporary error.

Examples: old exam notices, 2023 admission shortlists, gallery IDs, course material links.

---

## 7.13 PHP Handler

```apache
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php82 .php .php8 .phtml
</IfModule>
```

cPanel-managed. Sets `ea-php82` (PHP 8.2) as the handler for all PHP files. Do not edit manually — use WHM MultiPHP Manager.

---

*Last Updated: May 2026*
