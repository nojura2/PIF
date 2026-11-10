<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $dbs = array_diff(
        $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN),
        ['information_schema', 'mysql', 'performance_schema', 'sys']
    );
    $status = 'Connected to MySQL ' . $pdo->query('SELECT VERSION()')->fetchColumn();
} catch (PDOException $e) {
    $dbs = [];
    $status = 'DB error: ' . htmlspecialchars($e->getMessage());
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PIF Dev</title>
    <style>body{font-family:system-ui;max-width:700px;margin:40px auto;padding:0 16px}</style>
</head>
<body>
    <h1>PIF web server is running</h1>
    <p>PHP <?= PHP_VERSION ?> · <?= $status ?></p>
    <h2>Databases</h2>
    <?php if ($dbs): ?>
        <ul><?php foreach ($dbs as $d): ?><li><?= htmlspecialchars($d) ?></li><?php endforeach; ?></ul>
    <?php else: ?>
        <p>No database yet – create one with phpMyAdmin or <code>sql/create_database.sql</code>.</p>
    <?php endif; ?>
    <p><a href="info.php">phpinfo()</a> · <a href="http://localhost:8081">phpMyAdmin</a></p>
</body>
</html>
