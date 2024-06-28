<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item | Seans Bistro</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="form-container">
        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Include database connection
            require 'db_connection.php'; // Assume db_connection.php is in the same directory.

            // Get form data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;

            // Prepare SQL and bind parameters
            $stmt = $conn->prepare("INSERT INTO menu (name, description, price, category, is_featured) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsi", $name, $description, $price, $category, $is_featured);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p>New menu item added successfully. Redirecting in 3 seconds...</p>";
                echo "<script>setTimeout(() => { window.location.href = 'admin_dashboard.html'; }, 3000);</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close connection
            $stmt->close();
            $conn->close();
            exit();
        } else {
            // Display the form if the page is not submitted
        ?>
        <h1>Add a New Menu Item</h1>
        <form method="post" class="item-form">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price (€)</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category">
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_featured"> Is Featured?</label>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Item">
            </div>
        </form>
        <?php
        } // End of the else block
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
    
</body>
</html>
