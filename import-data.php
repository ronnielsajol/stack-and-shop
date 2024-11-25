<?php

require_once 'includes/config.php';

$csvFile = __DIR__ . '/data/lego_scrape.csv';

if (!file_exists($csvFile)) {
  die('File not found');
}

$fileHandle = fopen($csvFile, 'r');

if (!$fileHandle) {
  die("Failed to open CSV file.");
}


fgetcsv($fileHandle);

$sql = "INSERT INTO products (img_url, product_name, price, quantity, description) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);


while (($row = fgetcsv($fileHandle)) !== false) {

  $imgUrl = $row[0];

  $productNameParts = explode(',', $row[1]);
  $productName = trim($productNameParts[0]);

  $price = (float) str_replace(['PHP', 'php', 'Php', ','], '', $row[2]);
  $quantity = (int) str_replace(['in stock', 'In Stock'], '', $row[3]);
  $description = $row[4];


  $stmt->bind_param('ssdis', $imgUrl, $productName, $price, $quantity, $description);
  $stmt->execute();
}

fclose($fileHandle);

echo "Imported products successfully";
