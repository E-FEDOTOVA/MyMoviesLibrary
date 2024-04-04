<?php
session_start(); // Start the session
					
include 'mylib.php';

if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}

$firstName = filter_input(INPUT_GET,'firstName', FILTER_DEFAULT);
$lastName = filter_input(INPUT_GET, 'lastName', FILTER_DEFAULT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_GET, 'password', FILTER_DEFAULT);
$state = filter_input(INPUT_GET, 'state', FILTER_DEFAULT);
$zip = filter_input(INPUT_GET,'zip', FILTER_VALIDATE_INT);
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: signUp.php
	Purpose: lets user signup wit first, last name, email, and password. Can also provide state and zip -->
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
		<hr>
		<!-- Navigation Section -->
		<nav>
			<ul class="navigation-list">
				<!-- Navigation Links -->
				<li>
					<a href="home.php">Home</a>
				</li>
				<li>
					<a href="signUp.php">Sign Up</a>
				</li>
				<li>
					<?php	
					
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
			<div class="current-page">SIGN UP</div>
		</div>
		<!-- Sign Up Form Section -->
		<form class="modal-content" id="signupForm" method="POST" action="signUpDB.php" onsubmit="return validateForm()">
			<hr>
			<div class="form">
				<!-- Form Fields -->
				<p>
					<label for="firstName">First Name:</label>
					<input type="text" id="firstName" name="firstName" required>
				</p>
				<p>
					<label for="lastName">Last Name:</label>
					<input type="text" id="lastName" name="lastName" required>
				</p>
				<p>
					<label for="email">E-mail Address:</label>
					<input type="email" id="email" name="email" required>
				</p>
				<p>
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" required>
				</p>
				<p>
					<label for="state">State (optional):</label>
					<input type="text" id="state" name="state">
				</p>
				<p>
					<label for="zip">Zip (optional):</label>
					<input type="text" id="zip" name="zip">
				</p>
				<!-- Submit and Cancel Buttons -->
				<p>
					<button type="submit" onclick="confirmSubmit()">Submit</button>
					<button type="button" onclick="confirmCancel()">Cancel</button>
				</p>
			</div>
		</form>
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

			// Check if the email exists in the database
			$query = "SELECT * FROM Owner WHERE email = '$email'";
			$result = $db->query($query);

			if ($result) {
				if ($result->num_rows != 0) {
					// Redirect to the login page if email exists
					echo "<script>alert('Appears that you already have an account using this email. Login instead');</script>";
				} else {
					// Handle other cases or errors here
					echo "<script>alert('Error: Email does not exist.');</script>";
				}
			} else {
				// Handle database query errors here
				echo "<script>alert('Error: Database query error.');</script>";
			}
		}
		?>
		<script>
			function validateForm() {
				const firstName = document.getElementById('firstName').value;
				const lastName = document.getElementById('lastName').value;
				const email = document.getElementById('email').value;
				const password = document.getElementById('password').value;

				if (firstName === '' || lastName === '' || email === '' || password === '') {
					alert('Please fill in all required fields.');
					return false;
				}
			}

			function displayFormData() {
				const form = document.getElementById('signupForm');
				form.submit(); 
			}

			function clearForm() {
				const form = document.getElementById('signupForm');
				form.reset();
			}

			function confirmSubmit() {
				if (confirm('Are you sure you want to submit the form?')) {
					validateForm();
					displayFormData();
				}
			}

			function confirmCancel() {
				if (confirm('Are you sure you want to cancel?')) {
					clearForm();
				}
			}
		</script>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store</i>
		</p>
	</body>
</html>