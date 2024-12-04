<?php
require_once './model/Config.php';
require_once './model/Database.php';


$merchants = [
  ['username' => 'merchant1', 'email' => 'merchant1@example.com', 'password' => password_hash('password1', PASSWORD_DEFAULT), 'role' => 'merchant'],
  ['username' => 'merchant2', 'email' => 'merchant2@example.com', 'password' => password_hash('password2', PASSWORD_DEFAULT), 'role' => 'merchant'],
  ['username' => 'merchant3', 'email' => 'merchant3@example.com', 'password' => password_hash('password3', PASSWORD_DEFAULT), 'role' => 'merchant'],
  ['username' => 'merchant4', 'email' => 'merchant4@example.com', 'password' => password_hash('password4', PASSWORD_DEFAULT), 'role' => 'merchant'],
];

$merchantIds = [];
foreach ($merchants as $merchant) {
  $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->bind_param('s', $merchant['username']);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($existingId);
    $stmt->fetch();
    $merchantIds[] = $existingId;
  } else {
    $insertStmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param('ssss', $merchant['username'], $merchant['email'], $merchant['password'], $merchant['role']);
    $insertStmt->execute();
    $merchantIds[] = $conn->insert_id;
  }
}

$csvFile = __DIR__ . '/../data/lego_scrape.csv';
if (!file_exists($csvFile)) {
  die("CSV file not found");
}

$fileHandle = fopen($csvFile, 'r');
if (!$fileHandle) {
  die("Failed to open CSV file.");
}

fgetcsv($fileHandle);

$productIndex = 0; // Used for round-robin assignment of merchants
while (($row = fgetcsv($fileHandle)) !== false) {
  $imgUrl = $row[0];

  $productNameParts = explode(',', $row[1]);
  $productName = trim($productNameParts[0]);

  $price = (float)str_replace(['PHP', 'php', 'Php', ','], '', $row[2]);
  $quantity = (int)str_replace(['in stock', 'In Stock'], '', $row[3]);
  $description = $row[4];

  $merchantId = $merchantIds[$productIndex % count($merchantIds)];

  $stmt = $conn->prepare("INSERT INTO products (merchant_id, image, name, price, quantity, description) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param('issdis', $merchantId, $imgUrl, $productName, $price, $quantity, $description);
  $stmt->execute();

  $productIndex++;
}

fclose($fileHandle);

echo "Seeder completed successfully!";
