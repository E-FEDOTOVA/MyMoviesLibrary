<?php
include 'mylib.php';

$error = db_connect();
if ($error !== null) {
    die("Connection failed: " . $error);
}

$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$state = isset($_POST['state']) ? $_POST['state'] : null;
$zip = isset($_POST['zip']) ? $_POST['zip'] : null;

// Check if zip is empty, and if so, set it to null
$zip = ($zip === '') ? null : $zip;

$query = "INSERT INTO Owner (fname, lname, passwd, zip, state, email) VALUES ('$firstName', '$lastName', '$password', ";

// Check if state and zip are provided
if ($zip !== null && $state !== null) {
    $query .= "'$zip', '$state', ";
} else {
    $query .= "NULL, NULL, ";
}

$query .= "'$email')";

$result = $db->query($query);

if ($result === TRUE) {
    echo "<script>alert('Hello there, new user!');</script>";
	echo "<script>window.location.href = 'home.php';</script>";
} else {
    // Does the email already exist in the database
    if ($db->errno == 1062) {
        echo "<script>alert('Appears that you already have an account using this email. Redirecting to login...');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}

$db->close();
?>