# SJU Faculty Profile Management System v2.1

A robust, centralized system for managing faculty profiles at St. Joseph's University. This system bridges the Linways API with a local MySQL cache to ensure high availability, performance, and custom formatting. It features a fail-safe architecture that prevents data loss during API outages.

## 🚀 Features

- **Resilient Caching**: Fetches data from Linways API. If the API is down, the system automatically extends the life of cached data (even if expired) to ensure profiles remain visible.
- **Admin Dashboard**:
    - **Real-time Stats**: Total faculty, department breakdown, and cache size.
    - **API Latency Monitor**: Visual chart tracking the last 30 API response times.
    - **Search**: Instant search by Faculty Name or ID.
    - **Export**: Download the current cached faculty list as a CSV file.
- **Advanced Maintenance**:
    - **Safety-First Purge**: Checks API connectivity before allowing bulk deletion of expired records.
    - **Selective Purge**: Remove a specific faculty ID from the cache to force a re-sync.
    - **Force Purge**: Options to bypass safety checks or wipe the entire database in emergencies.
- **Zero-Downtime Sync**: Bulk import scripts use `REPLACE INTO` logic to update records seamlessly without truncating the table first.
- **Health Monitor**: A visual tool to inspect the freshness of every cached profile (Healthy, Urgent, Expired).
- **Log Management**: Detailed event logging with filtering (Error vs. Purge events).
- **Profile Generation**: Standardized, printable HTML profiles with QR codes and tabbed navigation.

## 📂 File Structure

### Core System
- **`dashboard.php`**: The main control panel. Displays stats, charts, logs, and maintenance tools.
- **`admin_update.php`**: Legacy admin panel for list management.
- **`i_db.php`**: The public-facing profile template. Handles database retrieval, API fallback, and HTML rendering.
- **`config.php`**: Configuration file for API tokens and passwords.
- **`settings.php`**: GUI to safely update credentials in `config.php`.

### Tools & Utilities
- **`view_logs.php`**: A dedicated viewer for `purge_history.log` with filtering capabilities.
- **`Health_check.php`**: A visual monitor to check cache expiration status for all faculty.
- **`cron_update_all.php`**: The script designed for Cron Jobs to update all profiles in the background.
- **`create_profiles.php`**: Generates static PHP wrapper files for individual faculty IDs.
- **`bulk_import.php`**: Manual bulk import tool.

## 🛠️ Setup & Installation

1.  **Database Configuration**
    Create a MySQL database and run the following SQL to create the cache table. Note the `fail_count` column for resilience logic.
    ```sql
    CREATE TABLE `api_cache` (
      `id` varchar(255) NOT NULL,
      `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `fail_count` int(11) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

2.  **Credentials**
    Ensure `config.php` is present in the root directory. You can create it manually or use `settings.php` after initial setup.
    ```php
    <?php
    date_default_timezone_set('Asia/Kolkata');
    $API_TOKEN = "your_linways_api_token";
    $ADMIN_PASSWORD = "your_admin_password";
    $CACHE_DIR = __DIR__ . '/cache';
    ?>
    ```

3.  **Permissions**
    - Ensure the web server has **write** permissions for the `cache/` directory (for file-based fallbacks).
    - Ensure the web server can create/write to `purge_history.log` and `api_latency.json`.
    - Ensure `config.php` is writable if you plan to use the Settings page.

## 🖥️ Usage

1.  **Login**: Access `dashboard.php` and enter the admin password.
2.  **Sync Data**: 
    - Use **Run Sync** (links to `cron_update_all.php`) to fetch the latest data.
    - This runs in the background and updates the database row-by-row.
3.  **Monitor Health**: 
    - Check the **API Response Time** chart on the dashboard to ensure the Linways API is responsive.
    - Use `Health_check.php` to see which profiles are expiring soon.
    - Check `view_logs.php` to see history of purges or errors.
4.  **Maintenance**: 
    - **Manual Purge**: Removes records older than 6 hours (Safe Mode).
    - **Selective Purge**: Enter a Faculty ID to remove just that record.
    - **Wipe Everything**: Truncates the database for a full reset.

## 🤖 Automation & Cron Jobs

### Manual Background Execution
```bash
sudo nohup php /home/sjubedu/public_html/Test/bulk_import.php > /home/sjubedu/public_html/Test/sync_results.log 2>&1 &
```
### Status check
sudo tail -f /home/sjubedu/public_html/Test/sync_results.log

### Master Sync (All Modules)
To run the complete sync (Faculty -> PhD -> Publications -> Projects -> Awards) in the background so you can close the terminal:
```bash
nohup php /home/sjubedu/public_html/Test/master_sync.php > /home/sjubedu/public_html/Test/master_sync.log 2>&1 &
nohup php /home/sjubedu/public_html/Test/bulk_import.php > /home/sjubedu/public_html/Test/cron_sync.log 2>&1 &

```
**Check Progress:**
```bash
tail -f /home/sjubedu/public_html/Test/master_sync.log
```

### Scheduled Cron Job
```bash
0 3 * * * php /home/sjubedu/public_html/Test/bulk_import.php >> /home/sjubedu/public_html/Test/cron_sync.log 2>&1
```

### Stop Process
```bash
sudo pkill -f bulk_import.php
```

## 🔍 Troubleshooting

- **Profiles showing old data?** The system might be in "Fail-Safe" mode because the API is down. Check `Health_check.php` to see if `fail_count` is increasing.
- **"System Maintenance" Error?** This appears only if the database is empty AND the API is down. Run `cron_update_all.php` manually to repopulate.
- **Permission Denied?** Check `chmod` settings for `purge_history.log`, `api_latency.json`, and `config.php`.

 # SJU Faculty Portal - Master Monitor System

## 📂 System Overview
This dashboard provides real-time traffic analysis and security for the SJU portal. It is designed to handle 10,000+ student visits with high-performance PDO queries and self-healing database logic.

## 🛠 Database Schema (SQL)
Run these in phpMyAdmin to set up your system:

```sql
-- 1. Active Traffic Tracking
CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50),
    location VARCHAR(100) DEFAULT 'Unknown',
    hit_count INT DEFAULT 1,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Security Firewall (Banned IPs)
CREATE TABLE IF NOT EXISTS banned_ips (
    ip_address VARCHAR(45) PRIMARY KEY,
    banned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Identification System (Nicknames)
CREATE TABLE IF NOT EXISTS ip_nicknames (
    ip_address VARCHAR(45) PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 4. Global Settings (Maintenance/Debug)
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value VARCHAR(255)
) ENGINE=InnoDB;
INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('maintenance_mode', 'off'), ('debug_logging', 'off');

Since we've integrated the **Health Score**, **Peak Traffic Analysis**, **Silent Error Handling**, and **AWS t3.medium optimizations**, your old documentation is outdated.

Here is the **Master README.md** for your SJU Faculty Portal. It is written to be a professional technical manual, which will look great as part of your portfolio for your Cybersecurity studies in Ireland.

---

# 🛡️ SJU Master Monitor System (v3.5)

**High-Performance Traffic Analytics & Server Security Suite**

## 📋 System Overview

This system is a custom-built monitoring engine designed to handle **10,000+ student sessions** on the SJU Portal. It prioritizes **Graceful Failure**—ensuring that even if the monitoring database or cPanel resources fail, the public-facing faculty profiles remain 100% accessible.

## 🚀 Core Features

* **Intelligent Health Grading:** An automated **A-F scoring system** that evaluates server health based on CPU load, RAM usage, and concurrent student traffic.
* **Silent Error Engine:** All tracking logic is wrapped in high-performance `try-catch` blocks with a **2-second DB timeout**, preventing server "hangs."
* **Traffic Wave Analysis:** A 24-hour visual graph that highlights **Peak Traffic** hours and dynamically changes color (Blue/Orange/Red) based on server capacity.
* **Dual-Domain Heartbeat:** Real-time 10-second patient cURL checks for both `sju.edu.in` and `sjub.edu.in`.
* **Cybersecurity Tools:** Native IP nicknaming, bulk blocking/unblocking, and WAF-compatible IP detection (Cloudflare).

## 📊 AWS t3.medium Optimization

This suite is specifically tuned for the **AWS t3.medium** instance (2 vCPUs, 4GB RAM):

* **Thresholds:** CPU Warning at **1.8**, Critical at **2.5**.
* **Capacity:** Designed to flag an "Overload" alert if hourly hits exceed **1,000**.
* **Burst Management:** Tracks total 24H hits to help monitor CPU credit consumption.

## 🛠️ Database Schema (SQL)

To deploy or rebuild the system, execute the following in **phpMyAdmin**:

```sql
-- 1. Analytics & Traffic
CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,  -- TEXT handles long query strings
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50),
    hit_count INT DEFAULT 1,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Security Firewall
CREATE TABLE IF NOT EXISTS banned_ips (
    ip_address VARCHAR(45) PRIMARY KEY,
    banned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Identity Manager
CREATE TABLE IF NOT EXISTS ip_nicknames (
    ip_address VARCHAR(45) PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

```

## 📂 File Structure

* `global_tracker.php`: The "Silent" tracking engine. Must be included at the top of every faculty profile.
* `/Test/Health_check.php`: The admin-only dashboard. Restricted by `is_admin` session check.
* `config.php`: (Outside public_html) Contains sensitive DB credentials.

## 📜 Principles of Operation

1. **Never Interfere:** The monitor is a secondary process. If it crashes, it must die silently without affecting the student's page load.
2. **Self-Healing:** If the `active_visitors` table is dropped or missing, the `global_tracker.php` will attempt to recreate it on the next visit.
3. **Data Integrity:** The system automatically converts `load_type` to `TEXT` if it detects a truncation warning, ensuring 100% log accuracy.

---

**Jogith, this README is now ready.** It explains the logic so clearly that any developer (or professor in Ireland) can see the cybersecurity thought process behind it.

**Would you like me to create a "Disaster Recovery" script that you can keep in your files just in case the server ever hits an "F" grade while you are asleep?**

