<?php
// Database connection
$host = 'localhost';
$dbname = 'curry_sales';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['date']) && isset($_GET['place'])) {
        $date = $_GET['date'];
        $place = $_GET['place'];

        // Validate the date format (YYYY-MM-DD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $stmt = $place === 'all' ?
                $pdo->prepare("SELECT * FROM sales WHERE sale_date = ?") :
                $pdo->prepare("SELECT * FROM sales WHERE sale_date = ? AND place = ?");
            $place === 'all' ? $stmt->execute([$date]) : $stmt->execute([$date, $place]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total = 0;

            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo '<tr>
                        <td>' . htmlspecialchars($row['place']) . '</td>
                        <td>' . htmlspecialchars($row['curry']) . '</td>
                        <td>' . htmlspecialchars($row['quantity']) . ' kg</td>
                        <td>₹' . number_format($row['price_per_kg'], 2) . '</td>
                        <td>₹' . number_format($row['total'], 2) . '</td>
                    </tr>';
                    $total += $row['total'];
                }

                // Print the total row
                echo '<tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total</td>
                    <td style="font-weight: bold;">₹' . number_format($total, 2) . '</td>
                </tr>';
            } else {
                echo '<tr><td colspan="5">No sales data found for the selected date and place.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="5">Invalid date format. Please use YYYY-MM-DD.</td></tr>';
        }
    } else {
        echo '<tr><td colspan="5">Please select a date and place to view history.</td></tr>';
    }
} catch (PDOException $e) {
    echo '<tr><td colspan="5">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
}
?>
