<?php
// Run this ONCE to create the database and table.
// Recommended: delete this file after running.

require __DIR__ . '/config.php';

$conn = db_connect();

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
$conn->select_db(DB_NAME);

// Create contacts table
$sql = "CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(255) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

echo "Setup completed successfully!<br>";
echo '<a href="index.php">Go to Contact Manager</a>';