# PIF – Local Web Development with Docker (HOWTO)

Replaces XAMPP: Apache + PHP, MySQL and phpMyAdmin run in Docker containers.

## 1. Requirements
- **Docker Desktop** installed and running
- **VS Code** with the extensions *Docker*, *PHP Intelephense*, *PHP Debug* (VS Code suggests them when you open the folder)
- Stop XAMPP if it is running (it uses the same ports)

## 2. Configure (`.env`)
Open `.env` and check:

| Setting | What to do |
|---|---|
| `PROJECT_NAME` | Leave `pif` (lowercase only) |
| `WEB_PORT`, `PMA_PORT`, `DB_PORT` | Change only if a port is already in use |
| `MYSQL_ROOT_PASSWORD` | Choose your own password **before the first start** |

## 3. Build and start
Open a terminal in the `PIF` folder (VS Code: *Terminal → New Terminal*):

```bash
docker compose up -d --build
```
The first build takes a few minutes. Check that all 3 containers are running:
```bash
docker compose ps
```

| Service | Address |
|---|---|
| Website | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| MySQL (from your PC) | `localhost:3306`, user `root` |
| MySQL (from PHP) | host **`db`**, user `root` |

## 4. Your files
Put your website in the **`www/`** folder. Changes are visible immediately in the browser – no restart needed.
Apache logs are in `logs/apache/`.

## 5. Create the database
The database server starts **empty**. Create your database yourself:

- **phpMyAdmin:** http://localhost:8081 → *New* → enter a name → collation `utf8mb4_unicode_ci` → *Create*
- **or SQL script:** write your script in `sql/` and import it in phpMyAdmin (*Import* tab), or run:
  ```bash
  docker compose exec -T db mysql -uroot -p<password> < sql/create_database.sql
  ```

Connect from PHP:
```php
$pdo = new PDO("mysql:host=db;dbname=pif;charset=utf8mb4", "root", getenv('DB_PASSWORD'));
```

## 6. Everyday commands
```bash
docker compose up -d        # start
docker compose stop         # stop (data is kept)
docker compose logs -f web  # show web server logs
docker compose exec web bash  # shell inside the web server
docker compose down -v      # remove everything INCLUDING the database (fresh start)
```

## 7. Debugging (optional)
In VS Code press **F5** → *Xdebug (Docker)*, set a breakpoint and open your page with `?XDEBUG_TRIGGER=1` at the end of the URL.

## Troubleshooting
- **"port is already allocated"** → change the port in `.env`, then `docker compose up -d`
- **Changed the root password but login fails** → the password is only set on the very first start; run `docker compose down -v` and start again (deletes all databases!)
