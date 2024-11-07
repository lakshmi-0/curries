<?php
// Database connection
$host = 'localhost';
$dbname = 'curry_sales';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receive and decode JSON data
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['sale_date'])) {
        $sale_date = $data['sale_date'];

        // Loop through each place and insert sales data
        foreach (['miyapur', 'ameerpet', 'oldcity'] as $place) {
            if (isset($data[$place]) && is_array($data[$place])) {
                foreach ($data[$place] as $item) {
                    $stmt = $pdo->prepare("INSERT INTO sales (sale_date, place, curry, quantity, leftover, price_per_kg, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $sale_date,
                        $place,
                        $item['curryName'],
                        $item['quantity'],
                        0, // Assuming no leftover for this entry
                        $item['price'],
                        $item['total']
                    ]);
                }
            }
        }
        echo "Sales data saved successfully!";
    } else {
        echo "Invalid sales data!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
