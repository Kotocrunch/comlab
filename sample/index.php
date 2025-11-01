<?php 
// Include the connection file so we can use $conn here
include 'conn.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Simple Book Inventory</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>📚 Book Inventory</h1>

  <?php
  // Check if the form has been submitted using the POST method
  // $_SERVER["REQUEST_METHOD"] is a superglobal variable
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // These $_POST superglobals hold the data sent from the HTML form
      $title = $_POST['title'];   // book title entered by user
      $author = $_POST['author']; // author entered by user
      $isbn = $_POST['isbn'];     // ISBN entered by user

      // Validate: check if all fields are filled
      if (!empty($title) && !empty($author) && !empty($isbn)) {

          // Prepare an SQL statement to prevent SQL injection
          $stmt = $conn->prepare("INSERT INTO books (title, author, isbn) VALUES (?, ?, ?)");
          // The question marks (?) are placeholders for the values to be inserted

          // Bind the actual values to the placeholders
          // "sss" means we are binding 3 strings (s = string)
          $stmt->bind_param("sss", $title, $author, $isbn);

          // Execute the SQL INSERT command
          if ($stmt->execute()) {
              // Display a success message if it worked
              echo "<p class='success'>✅ Book added successfully!</p>";
          } else {
              // Display error if something went wrong
              echo "<p class='error'>⚠️ Error: " . $stmt->error . "</p>";
          }

          // Close the prepared statement to free resources
          $stmt->close();

      } else {
          // If any field was empty, show an error
          echo "<p class='error'>⚠️ Please fill all fields.</p>";
      }
  }
  ?>

  <!-- HTML form to collect user input -->
  <form method="POST" action="">
    <input type="text" name="title" placeholder="Book Title">
    <input type="text" name="author" placeholder="Author">
    <input type="text" name="isbn" placeholder="ISBN">
    <button type="submit">Add Book</button>
  </form>

  <h2>📖 Current Inventory</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>ISBN</th>
    </tr>

    <?php
    // Retrieve data from the database using a SELECT query
    $sql = "SELECT * FROM books ORDER BY book_id ASC";

    // Run the query and store the result in $result
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            // Display each record as a table row
            echo "<tr>
                    <td>{$row['book_id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['isbn']}</td>
                  </tr>";
        }
    } else {
        // If no records exist, display a message
        echo "<tr><td colspan='4'>No books yet.</td></tr>";
    }
    ?>
  </table>
</div>
</body>
</html>
