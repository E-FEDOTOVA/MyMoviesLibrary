<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect unauthorized users to the login page
    header("Location: login.php");
    exit();
}
?>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: dispCollection.php
	Purpose: page that will display collection of movies from the database -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles.css">
		<title>My Movies Library</title>
		<style>
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
			<div class="current-page">DISPLAY COLLECTION</div>
		</div>
		<div class="container">
			<table> 
			<?php
			include 'mylib.php'; 

			$conn_error = db_connect();
			if ($conn_error !== null) {
				die("Connection failed: " . $conn_error);
			}

			$query = "SELECT dnum, isDigit, isDisk, title, year, imdbrating, actors, price, format,
						status
						FROM Disks NATURAL JOIN DiskMovies JOIN MovieInfo ON code = movCode
						ORDER BY dnum, title ;";

			$result = $db->query($query);

			if ($result->num_rows > 0) {
				echo "<table border='1'>
						<tr>
							<th>Title</th>
							<th>Year</th>
							<th>IMDB Rating</th>
							<th>Actors</th>
							<th>Price</th>
							<th>Format</th>
							<th>Status</th>
						</tr>";

				while ($row = $result->fetch_assoc()) {
					echo "<tr>
							<td>".$row['title']."</td>
							<td>".$row['year']."</td>
							<td>".$row['imdbrating']."</td>
							<td>".$row['actors']."</td>
							<td>".$row['price']."</td>
							<td>".$row['format']."</td>
							<td>".$row['status']."</td>
						</tr>";
				}
				echo "</table>";
			} else {
				echo "No movies found";
			}
			$db->close();
			?> </table>
		</div>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>