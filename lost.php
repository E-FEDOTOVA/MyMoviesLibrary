<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect unauthorized users to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: lost.php
	Purpose: report lost or bad movies to the database, updates status -->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles.css">
		<title>My Movies Library</title>
		<style>
			.construction {
				font-size: 70px;
				font-weight: bold;
				text-align: center;
				color: #ef476f;
			}

			.disclaimer {
				font-size: 16px;
				font-style: italic;
				text-align: center;
				color: #ffd166;
			}
		</style>
	</head>
	<body>
		<!-- Logo Section -->
		<div id="logo">
			<img src="images/logo.png" alt="Logo Image">
		</div>
		<!-- Horizontal Rule -->
		<hr>
		<!-- Navigation Section -->
		<nav>
			<!-- List of navigation links -->
			<ul class="navigation-list">
				<li>
					<a href="home.php">Home</a>
				</li>
				<li>
					<a href="signUp.php">Sign Up</a>
				</li>
				<li>
					<a href="logout.php">Logout</a>
				</li>
				<li>
					<a href="dispCollection.php">Display Collection</a>
				</li>
				<li>
					<a href="search.php">Search Movies</a>
				</li>
				<li>
					<a href="addStore.php">Add Store</a>
				</li>
				<li>
					<a href="editStore.php">Edit Store</a>
				</li>
				<li>
					<a href="purchase.php">Purchase Movies</a>
				</li>
				<li>
					<a href="viewPurchase.php">View Purchase</a>
				</li>
				<li>
					<a href="lost.php">Report Lost Movies</a>
				</li>
			</ul>
		</nav>
		<!-- Container Section -->
		<div class="container">
			<!-- Header Image Section -->
			<div id="header-image-menu">
				<img src="images/header.jpg" alt="Header Image">
			</div>
			<!-- Current Page Section -->
			<div class="current-page">LOST MOVIES</div>
		</div>
		<div class="container">
			<h2>Change Disk Status</h2>
			<form method="post" action="">
				<label for="disk_number">Enter Disk Number:</label>
				<input type="number" id="disk_number" name="disk_number" required>
				<label for="new_status">Change Status to:</label>
				<select name="new_status" id="new_status">
					<option value="Lost">Lost</option>
					<option value="Bad">Bad</option>
				</select>
				<input type="submit" value="Update Status">
			</form>
		</div>
		<div class="container">
		<?php
			include 'mylib.php';

			$conn_error = db_connect();
			if ($conn_error !== null) {
				die("Connection failed: " . $conn_error);
			}

			// Check if the form is submitted
			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$dnum = $_POST['disk_number'];
				$newStatus = $_POST['new_status'];

				// Query to retrieve movie information based on the provided disk number from DiskMovies table
				$sql = "SELECT dnum, movCode FROM DiskMovies WHERE dnum = $dnum";
				$result = $db->query($sql);

				if ($result->num_rows > 0) {
					echo "<table><tr><th>Disk Number</th><th>Movie Code</th><th>Movie Title</th>";
					while ($row = $result->fetch_assoc()) {
						$movCode = $row['movCode'];
						// Fetch movie titles from MovieInfo table based on movCode
						$movieQuery = "SELECT code, title FROM MovieInfo WHERE code = $movCode";
						$movieResult = $db->query($movieQuery);

						if ($movieResult->num_rows > 0) {
							while ($movieRow = $movieResult->fetch_assoc()) {
								echo "<tr><td>" . $row['dnum'] . "</td><td>" . $row['movCode'] . "</td><td>" . $movieRow['title'] . "</td></tr>";
							}
						} else {
							echo "<tr><td>" . $row['dnum'] . "</td><td>" . $row['movCode'] . "</td><td>No title found</td></tr>";
						}
					}
					echo "</table>";

					// Update status when the form is submitted
					$updateQuery = "";
					if ($newStatus == 'Lost') {
						$updateQuery = "UPDATE Disks SET Status = 'L' WHERE dnum = $dnum";
					} elseif ($newStatus == 'Bad') {
						$updateQuery = "UPDATE Disks SET Status = 'B' WHERE dnum = $dnum";
					}

					if (!empty($updateQuery)) {
						if ($db->query($updateQuery) === TRUE) {
							echo "<p style='color:#ffd166;'>Status updated successfully</p>";
						} else {
							echo "<p style='color:#ffd166;'>Error updating status: " . $db->error . "</p>";
						}
					}
				} else {
					echo "<p style='color:#ffd166;'>No movies found for the provided disk number</p>";
				}
				$db->close(); // Close the database connection
			}
			?>
		</div>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>