<?php
$db = new PDO('mysql:host=localhost;dbname=spendly_db', 'root', '');
$db->exec('ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 0, ADD COLUMN otp_code VARCHAR(6), ADD COLUMN otp_expires_at DATETIME;');
echo "Success\n";
?>
