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
	Filename: editStore.php
	Purpose: page that allows user to edit store name or delete it -->
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
			<div class="current-page">EDIT STORE</div>
		</div>
		<!-- Store Edit/Delete Form Section -->
		<form class="modal-content" id="editStoreForm" action="editStoreDB.php" method="POST">
			<hr>
			<div class="form">
				<p>Please select the store name to edit or delete.</p>
				<p>
					<label for="storeName">
						<b>Select Store Name</b>
					</label>
					<select name="storeName" required>
						<?php
						include 'mylib.php';
						$error = db_connect();
						if ($error !== null) {
							die("Connection failed: " . $error);
						}

						$query = "SELECT sname FROM Store WHERE sname IS NOT NULL AND sname != ''";
						$result = $db->query($query);

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "<option value='" . $row['sname'] . "'>" . $row['sname'] . "</option>";
							}
						}
						$db->close();
						?>
					</select
				</p>
				<p>
					<label for="editOption">
						<b>Choose Action:</b>
					</label>
					<select name="editOption">
						<option value="edit">Edit Store Name</option>
						<option value="delete">Delete Store</option>
					</select>
				</p>
				<p id="newStoreNameField" style="display: none;">
					<label for="newStoreName">
						<b>New Store Name</b>
					</label>
					<input type="text" placeholder="Enter New Store Name" name="newStoreName">
				</p>
				<!-- Submit and Cancel Buttons -->
				<button type="submit" onclick="confirmSubmit()">Submit</button>
				<button type="button" onclick="confirmCancel()">Cancel</button>
			</div>
		</form>
		<script>
			function confirmSubmit() {
			if (confirm('Are you sure you want to submit the form?')) {
			} else {
				document.querySelector('input[name="newStoreName"]').value = '';
				event.preventDefault(); 
			}
}
			function confirmCancel() {
				if (confirm('Are you sure you want to cancel?')) {
					document.querySelector('input[name="newStoreName"]').value = '';
				}
			}
			document.querySelector('select[name="editOption"]').addEventListener('change', function() {
				var newStoreNameField = document.getElementById('newStoreNameField');
				if (this.value === 'edit') {
					newStoreNameField.style.display = 'block';
				} else {
					newStoreNameField.style.display = 'none';
				}
			});
			window.addEventListener('DOMContentLoaded', function() {
				var newStoreNameField = document.getElementById('newStoreNameField');
				var editOption = document.querySelector('select[name="editOption"]');
				if (editOption.value === 'edit') {
					newStoreNameField.style.display = 'block';
				}
			});
		</script>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>