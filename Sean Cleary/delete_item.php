<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Menu Item | Seans Bistro</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="form-container">
        <?php
        require_once 'db_connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name'])) {
            $itemName = $_POST['name'];

            // Prepare SQL to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM menu WHERE name = ?");
            $stmt->bind_param("s", $itemName);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<p>Menu item deleted successfully. Redirecting in 3 seconds...</p>";
                echo "<script>setTimeout(() => { window.location.href = 'admin_dashboard.html'; }, 3000);</script>";
            } else {
                echo "<p>Item not found or could not be deleted.</p>";
            }

            $stmt->close();
            $conn->close();
        } else {
            // Display the form if no POST request has been made
        ?>
        <h1>Delete a Menu Item</h1>
        <form method="post" class="item-form">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter the name of the item to delete">
            </div>
            <div class="form-group">
                <input type="submit" value="Delete Item">
            </div>
        </form>
        <?php
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
    
</body>
</html>
