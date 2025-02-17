<?php

$host = 'db'; // Use the service name from docker-compose.yml (MySQL service name)
$db = 'php-app-deploy'; // Make sure this matches the database name in your docker-compose.yml
$user = 'root'; // This should be the same as MYSQL_ROOT_USER from docker-compose.yml (default is root)
$pass = 'myDbPassForWebApp123'; // This should be the same as MYSQL_ROOT_PASSWORD from docker-compose.yml
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $con = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
