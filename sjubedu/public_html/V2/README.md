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
* `emergency_reset.php`: Nuclear option to wipe all databases (`key` required).

### **Monitoring & Automation**

* `global_tracker.php`: The "Silent" tracking engine included in all profile headers.
* `Health_check.php`: Visual dashboard for cache freshness and server load.
* `master_sync.php`: Background script for full module synchronization.
* `bulk_import.php`: Manual bulk import tool with logging.

### **Module Generators**
* `bulk_*_generator.php`: Generates static PHP files for specific modules (e.g., `bulk_events_organized_generator.php`).
* `bulk_*_live_generator.php`: Generates live-fetch versions of module pages.

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

CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50) NOT NULL, -- Detects TV, Watch, Tablet, Mobile, Desktop
    carrier VARCHAR(100) DEFAULT 'Unknown', -- Detects Jio, Airtel, etc.
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