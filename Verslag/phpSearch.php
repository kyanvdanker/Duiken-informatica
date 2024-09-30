<?php
$search = $_POST['search'];

$servername = "localhost:3306";
$username = "root";
$password = "3Musketiers!";
$db = "databaseduiken";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$sql = "SELECT Datum, Duur, Diepte, No_decompression_time, Decompression_time 
        FROM duiken 
        WHERE Datum LIKE '%$search%'";

$result = $conn->query($sql);

// Start outputting the HTML table for results
echo "<table border-collapse='collapese' padding='8px'  style='width: 100%;'>
        <thead>
            <tr style='background-color: white; font-family: ariel;'>
                <th>Datum</th>
                <th>Duur</th>
                <th>Diepte</th>
                <th>No_decompression_time</th>
                <th>Decompression_time</th>
            </tr>
        </thead>
        <tbody>";

// Check if there are results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: white; font-family: ariel;'>
                <td>" . $row["Datum"] . "</td>
                <td>" . $row["Duur"] . "</td>
                <td>" . $row["Diepte"] . "</td>
                <td>" . $row["No_decompression_time"] . "</td>
                <td>" . $row["Decompression_time"] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}

echo "</tbody></table>";

// Close the database connection
$conn->close();
?>