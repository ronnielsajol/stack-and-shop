<?php

require_once __DIR__ . '/includes/config.php';

$csvFile = __DIR__ . '/data/lego_scrape.csv';

$merchantId = 3; // Replace with the actual merchant ID as needed

if (!file_exists($csvFile)) {
  die('Error: CSV file not found.');
}

$fileHandle = fopen($csvFile, 'r');
if (!$fileHandle) {
  die('Error: Failed to open CSV file.');
}

fgetcsv($fileHandle);

$sql = "INSERT INTO products (img_url, product_name, price, quantity, description, merchant_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
  die('Error: Failed to prepare SQL statement. ' . $conn->error);
}

while (($row = fgetcsv($fileHandle)) !== false) {
  $imgUrl = $row[0];

  $productNameParts = explode(',', $row[1]);
  $productName = trim($productNameParts[0]);

  $price = (float) str_replace(['PHP', 'php', 'Php', ','], '', $row[2]);

  $quantity = (int) str_replace(['in stock', 'In Stock'], '', $row[3]);

  $description = $row[4];

  if (!$stmt->bind_param('ssdisi', $imgUrl, $productName, $price, $quantity, $description, $merchantId)) {
    die('Error: Failed to bind parameters. ' . $stmt->error);
  }

  if (!$stmt->execute()) {
    die('Error: Failed to execute SQL statement. ' . $stmt->error);
  }
}

// Close the file and the statement
fclose($fileHandle);
$stmt->close();

// Output success message
echo "Products imported successfully for merchant ID: $merchantId.";
