

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Seans Bistro</title>
    <link rel="stylesheet" href="style.css"> <!-- Main stylesheet -->
    <style>
       
       h1 {
            text-align: center; /* Centers the title */
            margin-top: 5px; /* Adds some space at the top of the page */
        }
        .menu-list {
            margin: 20px auto;
            width: 80%;
            max-width: 1200px;
        }

        .menu-item {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .menu-item h3 {
            color: #333;
            margin-bottom: 5px;
        }

        .menu-item-description {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .menu-item-price {
            font-weight: bold;
            color: #008000;
        }
    </style>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="Restaurant.html">Home</a></li>
                <li><a href="menu.php">Menu</a></li> <!-- Updated link to reflect .php extension -->
                <li><a href="reservation_form.php">Reservations</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact_form.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h1>Our Menu</h1> <!-- Title for the menu section -->

        <section class="menu-items">
            <?php
            require_once 'db_connection.php'; // Include your database connection file

            // Define the query to fetch all menu items
            $query = "SELECT * FROM menu ORDER BY category, name";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Start the HTML string for menu items
                echo '<div class="menu-list">';
                
                // Fetch each row as an associative array
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">';
                    echo '<h3 class="menu-item-name">' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="menu-item-description">' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="menu-item-price">$' . number_format($row['price'], 2) . '</p>';
                    echo '</div>';
                }
                
                echo '</div>';
            } else {
                echo '<p>No menu items found.</p>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </section>
    </main>
    
   
</body>
</html>
