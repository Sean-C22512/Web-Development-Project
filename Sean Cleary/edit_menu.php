<?php
require_once 'db_connection.php';  // Ensure you have a database connection file

// Handle POST request to update data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Prepare the update SQL statement
    $sql = "UPDATE menu SET name = ?, description = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $name, $description, $price, $id);
    if ($stmt->execute()) {
        echo "<p>Menu item updated successfully.</p>";
    } else {
        echo "<p>Error updating record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Include HTML header and body tags
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item | Seans Bistro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form, ul {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-top: 1em;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004494;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li a {
            color: #0056b3;
            text-decoration: none;
        }

        li a:hover {
            text-decoration: underline;
        }

        footer {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Menu Items</h1>
    <?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM menu WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($item) {
            // Show the edit form
            ?>
            <form action="edit_menu.php" method="post">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>

                <input type="submit" value="Update Item">
            </form>
            <?php
        } else {
            echo "<p>Menu item not found.</p>";
        }
        $stmt->close();
    } else {
        // List all menu items with edit links
        $sql = "SELECT * FROM menu";
        $result = $conn->query($sql);

        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li><a href="edit_menu.php?id=' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</a></li>';
        }
        echo '</ul>';
    }
    ?>
    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
</body>
</html>

