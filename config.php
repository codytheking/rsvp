<?php
/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "codyjkin_codyjk";
$password   = "y55pWWH\$C@1&";
$dbname     = "codyjkin_testing"; 
$charset    = "utf8mb4";

$dsn        = "mysql:host=$host;dbname=$dbname;charset=$charset"; 
$options    = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
?>