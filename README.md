# Panoráma Képek Galéria

Egy egyszerű webes alkalmazás panoráma képek megjelenítéséhez és kezeléséhez.

## Funkciók

- Panoráma képek listázása
- Kategóriák szerinti szűrés
- Új panoráma hozzáadása
  - Legördülő menüből választható kamera típusok
  - Legördülő menüből választható kategóriák
- Lapozás
- Kameratípusok megjelenítése

## Telepítés

1. Klónozza le a repository-t:
```bash
git clone [repository-url]
```

2. Telepítse a függőségeket:
```bash
composer install
```

3. Másolja ki a `.env.example` fájlt `.env` néven és állítsa be az adatbázis kapcsolatot:
```bash
cp .env.example .env
```

4. Állítsa be az adatbázis kapcsolatot a `.env` fájlban:
```
DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
```

5. Hozza létre az adatbázist és a szükséges táblát:
```sql
CREATE DATABASE your_database_name;
USE your_database_name;

CREATE TABLE panoramas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    comment TEXT,
    cam_type VARCHAR(1),
    category VARCHAR(50)
);
```

## Fájlstruktúra

- `pan.php` - Főoldal, a panorámák listázása
- `add_panorama.php` - Új panoráma hozzáadása
- `Database.php` - Adatbázis kapcsolat kezelése
- `Panorama.php` - Panoráma adatok kezelése
- `config.php` - Konfigurációs beállítások
- `.env` - Környezeti változók (adatbázis kapcsolat)

## Követelmények

- PHP 7.4 vagy újabb
- MariaDB/MySQL
- Composer

## Biztonság

- PDO használata az SQL injection ellen
- XSS védelem htmlspecialchars() használatával
- Környezeti változók használata az érzékeny adatok tárolásához

## Licensz

Ez a projekt MIT licensz alatt van. Lásd a `LICENSE` fájlt részletekért.
