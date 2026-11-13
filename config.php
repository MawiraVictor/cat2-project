<?php
// Database connection shared by all pages
$DB_HOST = 'localhost';
$DB_USER = 'cat2user';
$DB_PASS = 'StrongPass#2026';
$DB_NAME = 'CAT2';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed: ' . htmlspecialchars($conn->connect_error));
}
session_start();
