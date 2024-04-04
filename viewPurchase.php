<?php

session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect unauthorized users to the login page
    header("Location: login.php");
    exit();
}

include 'mylib.php';

$db_error = db_connect();
if ($db_error) {
    die("Connection failed: " . $db_error);
}

$query = "SELECT pno, pdate, sname, count(dnum) AS total_disks
          FROM Purchase 
          NATURAL JOIN PurchDetails 
          NATURAL JOIN Disks 
          NATURAL JOIN DiskMovies
          GROUP BY pno, pdate, sname
          ORDER BY pno";

$result = $db->query($query);
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: viewPurchase.php
	Purpose: page that lets user view purchase history -->
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

			.hover-effect:hover {
				background-color: #ef476f;
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
		<div class="container">
			<!-- Header image section -->
			<div id="header-image-menu">
				<img src="images/header.jpg" alt="Header Image">
			</div>
			<!-- Current page section -->
			<div class="current-page">VIEW PURCHASE</div>
		</div>
		<div class="container">
			<!-- Table to display purchases -->
			<table>
				<thead>
					<tr>
						<th>Purchase Number</th>
						<th>Date</th>
						<th>Store Name</th>
						<th>Total Disks</th>
					</tr>
				</thead>
				<tbody> <?php
                while ($row = $result->fetch_assoc()) {
				$pno = $row['pno']; 
				echo "<tr onclick=\"window.location='viewPurchDet.php?pno=$pno';\"class=\"hover-effect\">";
				echo "<td>{$row['pno']}</td>";
				echo "<td>{$row['pdate']}</td>";
				echo "<td>{$row['sname']}</td>";
				echo "<td>{$row['total_disks']}</td>";
				echo "</tr>";
			}
                ?> </tbody>
			</table>
		</div>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>