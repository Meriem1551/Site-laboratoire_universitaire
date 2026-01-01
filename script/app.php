<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=tdw;charset=utf8",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Connection OK";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
