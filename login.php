<?php
session_start();
include 'mylib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish database connection
    $error = db_connect();
    if ($error !== null) {
        die("Connection failed: " . $error);
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'psw', FILTER_DEFAULT);

    if ($email && $password) {
        // Using prepared statements to prevent SQL injection
        $query = "SELECT * FROM Owner WHERE email = ? AND passwd = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $_SESSION['email'] = $email;
            echo "<script>alert('Login successful!');</script>";
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please provide both email and password.');</script>";
    }

    $stmt->close();
    $db->close();
}
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: login.php
	Purpose: login page for MML. Required to access the majority of the website, besides sign up and home -->
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
		<div id="logo">
			<img src="images/logo.png" />
		</div>
		<hr>
		<nav>
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
		<div class="container">
			<div id="header-image-menu">
				<img src="images/header.jpg" alt="Header Image">
			</div>
			<div class="current-page">LOGIN</div>
		</div>
		<form class="modal-content" id="loginForm" method="POST" action="login.php">
			<hr>
			<div class="form">
				<p>Please enter your credentials to log in.</p>
				<p>
					<label for="email">
						<b>Email</b>
					</label>
					<input type="email" placeholder="Enter Email" name="email" required>
				</p>
				<p>
					<label for="psw">
						<b>Password</b>
					</label>
					<input type="password" placeholder="Enter Password" name="psw" required autocomplete="off">
				</p>
				<button type="submit">Submit</button>
				<button type="button" onclick="confirmCancel()">Cancel</button>
				<p>First time here? <a href="signUp.php">Sign up</a></p>
			</div>
		</form>
		<script>
			function displayFormData() {
				const form = document.getElementById('signupForm');
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
				const form = document.getElementById('signupForm');
				form.reset();
			}
			function confirmSubmit() {
				if (confirm('Are you sure you want to submit the form?')) {
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
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>