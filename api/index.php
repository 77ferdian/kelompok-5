<?php

// Forward Vercel requests to normal index.php
// Pastikan SQLite disiapkan di direktori /tmp yang writable jika belum ada
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';

if (!file_exists($tmpDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $tmpDb);
} elseif (!file_exists($tmpDb)) {
    @touch($tmpDb);
}

putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE={$tmpDb}");
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $tmpDb;

require __DIR__ . '/../public/index.php';
