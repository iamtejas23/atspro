# LAMP Stack PHP Application with MySQL Integration

## Project Overview

This project sets up and deploys a PHP-based application using a LAMP stack (Linux, Apache, MySQL, PHP) on an Amazon Linux EC2 instance. The application interacts with a MySQL database to store and retrieve resume data.

---

## 1. Server Environment

### OS:

* Amazon Linux 2023

### Software Stack:

* Apache HTTP Server (httpd)
* MySQL Server (MariaDB)
* PHP 8.2

---

## 2. LAMP Stack Installation

### Apache Installation

```bash
sudo yum install httpd -y
sudo systemctl start httpd
sudo systemctl enable httpd
```

### PHP Installation

```bash
sudo amazon-linux-extras enable php8.2
sudo yum clean metadata
sudo yum install php php-mysqlnd -y
```

### MySQL (MariaDB) Installation

```bash
sudo yum install mariadb105-server -y
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

---

## 3. Database Configuration

### Create Database and Table

```sql
CREATE DATABASE ats_scanner;
USE ats_scanner;

CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    score FLOAT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Create MySQL User (Optional)

```sql
CREATE USER 'root'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON ats_scanner.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```

---

## 4. PHP Application Setup

### Project Directory:

`/var/www/html/atspro/`

### File Permissions

```bash
sudo chown -R apache:apache /var/www/html/atspro/
sudo chmod -R 755 /var/www/html/atspro/
```

### Sample PHP DB Connection (db.php)

```php
<?php
$mysqli = new mysqli("localhost", "root", "your_mysql_password", "ats_scanner");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
```

---

## 5. Apache Configuration

### Ensure Apache can serve PHP:

* Default configuration is sufficient.
* Make sure there is an `index.php` file or update DirectoryIndex.

### Restart Apache:

```bash
sudo systemctl restart httpd
```

---

## 6. Access Application

* Browser URL: `http://<EC2-Public-IP>/atspro/`

---

## 7. Log Debugging

### Apache Error Logs:

```bash
sudo tail -f /var/log/httpd/error_log
```

Look for errors related to file permissions, missing files, or PHP/MySQL issues.



## End of Documentation
