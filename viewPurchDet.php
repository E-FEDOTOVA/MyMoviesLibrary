<?php
include 'mylib.php';

$pno = filter_input(INPUT_GET, 'pno');

if (!$pno) {
    die("Invalid purchase number.");
}

$db_error = db_connect();
if ($db_error) {
    die("Connection failed: " . $db_error);
}

$query = "SELECT pno, pdate, sname, dnum, price, format, status, isDigit, isDisk,
			title, year
			FROM Purchase NATURAL JOIN PurchDetails NATURAL JOIN Disks NATURAL JOIN
			DiskMovies JOIN MovieInfo ON code = movCode
			WHERE pno = $pno
			ORDER BY dnum, title;";

$result = $db->query($query);
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: viewPurchaseDet.php
	Purpose: page that shows purchase details -->
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
				/* Text color */
			}
		</style>
	</head>
	<body>
		<!-- Logo section -->
		<div id="logo">
			<img src="images/logo.png" alt="Logo Image">
		</div>
		<hr>
		<!-- Navigation section -->
		<nav>
			<ul class="navigation-list">
				<li>
					<a href="home.php">Home</a>
				</li>
				<li>
					<a href="signUp.php">Sign Up</a>
				</li>
				<li>
					<a href="login.php">Login</a>
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
		<div class="container">
			<!-- Header image section -->
			<div id="header-image-menu">
				<img src="images/header.jpg" alt="Header Image">
			</div>
			<!-- Current page section -->
			<div class="current-page">VIEW PURCHASE DETAILS</div>
		</div>
		<div class="container">
			<table>
				<thead>
							<tr>
								<th>Purchase Number</th>
								<th>Date</th>
								<th>Store Name</th>
								<th>Disk Number</th>
								<th>Price</th>
								<th>Format</th>
								<th>Status</th>
								<th>Is Digit</th>
								<th>Is Disk</th>
								<th>Title</th>
								<th>Year</th>
							</tr>
				</thead>
				<tbody>
					<?php
					if ($result && $result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>{$row['pno']}</td>";
						echo "<td>{$row['pdate']}</td>";
						echo "<td>{$row['sname']}</td>";
						echo "<td>{$row['dnum']}</td>";
						echo "<td>{$row['price']}</td>";
						echo "<td>{$row['format']}</td>";
						echo "<td>{$row['status']}</td>";
						echo "<td>" . ($row['isDigit'] ? 'Yes' : 'No') . "</td>";
						echo "<td>" . ($row['isDisk'] ? 'Yes' : 'No') . "</td>";
						echo "<td>{$row['title']}</td>";
						echo "<td>{$row['year']}</td>";
						echo "</tr>";
					}
					} else {
						echo "<p>No details found for this purchase.</p>";
					}
					?>
				</tbody>
			</table>
		</div>
			<!-- Disclaimer message -->
			<p class="disclaimer"> This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store </p>
	</body>
</html>