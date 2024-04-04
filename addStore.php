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
	Filename: addStore.php
	Purpose: page that will add a user specified store to the database -->
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
			<div class="current-page">ADD STORE</div>
		</div>
		<!-- Add Store Form Section -->
		<form class="modal-content" id="addStoreForm" action="addStoreDB.php" method="POST">
			<hr>
			<div class="form">
				<p>Please enter the store name.</p>
				<p>
					<label for="storeName">
						<b>Store Name</b>
					</label>
					<input type="text" placeholder="Enter Store Name" name="storeName" required>
				</p>
				<!-- Submit and Cancel Buttons -->
				<button type="submit" onclick="confirmSubmit()">Submit</button>
				<button type="button" onclick="confirmCancel()">Cancel</button>
			</div>
		</form>
		<!-- Existing store names -->
		<ul>
		<h3>Existing Stores:</h3>
		<div class="existing-stores">
				<?php
				include 'mylib.php';
				$error = db_connect();
				if ($error !== null) {
					die("Connection failed: " . $error);
				}
				$query = "SELECT sname FROM Store WHERE sname <> ''";
				$result = $db->query($query);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<li>" . $row["sname"] . "</li>";
					}
				} else {
					echo "<li>No stores found</li>";
				}
				$db->close();
				?>
		</div>
		</ul>
		<script>
			function displayFormData() {
				const form = document.getElementById('storeName');
				const formData = new FormData(form);
				let allRequiredFilled = true;
				for (const input of form.querySelectorAll('[required]')) {
					if (!formData.has(input.name) || formData.get(input.name) === '') {
						alert(`Please fill in the required field: ${input.name}`);
						allRequiredFilled = false;
						break;
					}
				}
				if (allRequiredFilled) {
					for (const pair of formData.entries()) {
						alert(`${pair[0]}: ${pair[1]}`);
					}
					form.reset();
				}
			}
			function clearForm() {
				const form = document.getElementById('storeName');
				form.reset();
			}
			function confirmSubmit() {
				if (confirm('Are you sure you want to submit the form?')) {
					displayFormData();
				} else {
					document.querySelector('input[name="storeName"]').value = '';
				}
			}
			function confirmCancel() {
				if (confirm('Are you sure you want to cancel?')) {
					document.querySelector('input[name="storeName"]').value = '';
				}
			}
			
		</script>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>