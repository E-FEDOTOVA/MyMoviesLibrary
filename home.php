<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: home.php
	Purpose: Homepage for My Movie Library Phase 3(final) -->
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

			.welcome {
				font-size: 25px;
				font-style: bold;
				text-align: center;
				color: #ffd166;
				/* Text color */
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
					<?php
					session_start(); // Start the session

					// Check if the user is logged in
					if (isset($_SESSION['email'])) {
						echo '<a href="logout.php">Logout</a>';
					} else {
						// If not logged in, show the login link
						echo '<a href="login.php">Login</a>';
					}
					?>
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
			<div class="current-page">HOME</div>
		</div>
		<div class="welcome"> 
		<?php
		session_start(); // Start session https://www.php.net/manual/en/function.session-start.php

		include 'mylib.php';

		// Is user is logged in?
		if (isset($_SESSION['email'])) {
			$error = db_connect();
			$email = $_SESSION['email'];
			$query = "SELECT fname FROM Owner WHERE email = '$email'";
			$result = $db->query($query);

			if ($result && $result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$fname = $row['fname'];
				echo "<div>Welcome, $fname!</div>";
			} else {
				echo "<div>Welcome!</div>";
			}

			echo '<div><a href="logout.php">Logout?</a></div>';
			if ($error !== null) {
				die("Connection failed: " . $error);
			}
			$db->close();
		} else {
			// If not logged in, display a login prompt
			echo "<div>Welcome! Would you like to <a href='login.php' style='color: #ef476f;'>Login</a> 
					or <a href='signUp.php' style='color: #ef476f;'>Sign Up?</a></div>";
		}
		?> </div>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<!-- Disclaimer message -->
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>