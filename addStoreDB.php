<?php
include 'mylib.php';

$error = db_connect();
if ($error !== null) {
    die("Connection failed: " . $error);
}

$storeName = $_POST['storeName'];

$query = "INSERT INTO Store (sname) VALUES ('$storeName')";

$result = $db->query($query);

if ($result === TRUE) {
    echo "New record created successfully";
	echo "<p><a href='addStore.php'>Go back to Add Store page</a></p>";
} else {
    if ($db->errno == 1062) {
        echo "Error: This store name already exists.";
		echo "<p><a href='addStore.php'>Go back to Add Store page</a></p>";
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
		echo "<p><a href='addStore.php'>Go back to Add Store page</a></p>";
    }
}

$db->close();
?>