<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<!--Author: Kate Fedotova
	Major: Computer Science
	Due Date: December 6, 2023
	Course: CSC242
	Filename: purchase.php
	Purpose: page ask user about their purchase, user can submit up to 3 movies on one disk -->
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
  				color: #ef476f; /* Text color */
        			} 
			.disclaimer {
  				font-size: 16px;
  				font-style: italic;
  				text-align: center;
  				color: #ffd166; /* Text color */
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
			<div class="current-page">PURCHASE MOVIES</div>
		</div>
		<!-- Purchase Form Section -->
		<div class="container">
			<h2>Purchase Movies</h2>
			<div id="form-fields">
			<form method="POST" action="">
			
				<label for="purchase_date">Purchase Date:</label>
				<input type="date" id="purchase_date" name="purchase_date" required><br><br>

				<label for="store_name">Store Name:</label>
				<input type="text" id="store_name" name="store_name" required><br><br>

				<!-- Fields for Disk Information -->
				<label for="disk_number">Disk Number:</label>
				<input type="number" id="disk_number" name="disk_number" required><br><br>

				<label for="disk_price">Disk Price:</label>
				<input type="number" id="disk_price" name="disk_price" required><br><br>

				<label for="disk_format">Disk Format:</label>
				<input type="text" id="disk_format" name="disk_format" required><br><br>

				<!-- Movie 1 Information -->
				<h3>Movie 1</h3>
				<label for="movie_title_1">Movie Title:</label>
				<input type="text" id="movie_title_1" name="movie_title_1" required><br><br>

				<label for="movie_genre_1">Movie Genre:</label>
				<input type="text" id="movie_genre_1" name="movie_genre_1" required><br><br>

				<label for="movie_year_1">Year Released:</label>
				<input type="number" id="movie_year_1" name="movie_year_1" required><br><br>

				<label for="imdb_rating_1">IMDB Rating:</label>
				<input type="text" id="imdb_rating_1" name="imdb_rating_1" required><br><br>

				<label for="actors_1">Leading Actors' Names:</label>
				<input type="text" id="actors_1" name="actors_1" required><br><br>

				<!-- Movie 2 Information -->
				<h3>Movie 2</h3>
				<label for="movie_title_2">Movie Title:</label>
				<input type="text" id="movie_title_2" name="movie_title_2" ><br><br>

				<label for="movie_genre_2">Movie Genre:</label>
				<input type="text" id="movie_genre_2" name="movie_genre_2" ><br><br>

				<label for="movie_year_2">Year Released:</label>
				<input type="number" id="movie_year_2" name="movie_year_2" ><br><br>

				<label for="imdb_rating_2">IMDB Rating:</label>
				<input type="text" id="imdb_rating_2" name="imdb_rating_2" ><br><br>

				<label for="actors_2">Leading Actors' Names:</label>
				<input type="text" id="actors_2" name="actors_2" ><br><br>

				<!-- Movie 3 Information -->
				<h3>Movie 3</h3>
				<label for="movie_title_3">Movie Title:</label>
				<input type="text" id="movie_title_3" name="movie_title_3" ><br><br>

				<label for="movie_genre_3">Movie Genre:</label>
				<input type="text" id="movie_genre_3" name="movie_genre_3" ><br><br>

				<label for="movie_year_3">Year Released:</label>
				<input type="number" id="movie_year_3" name="movie_year_3" ><br><br>

				<label for="imdb_rating_3">IMDB Rating:</label>
				<input type="text" id="imdb_rating_3" name="imdb_rating_3" ><br><br>

				<label for="actors_3">Leading Actors' Names:</label>
				<input type="text" id="actors_3" name="actors_3" ><br><br>

				<p>
					<button type="submit" onclick="confirmSubmit()">Submit</button>
					<button type="button" onclick="confirmCancel()">Cancel</button>
				</p>
			</form>
			</div>
		</div>
		<script>
		function clearForm() {
				const form = document.getElementById('form-fields');
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
		<?php
			include 'mylib.php'; 

			$conn_error = db_connect();
			if ($conn_error !== null) {
				die("Connection failed: " . $conn_error);
			}

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$purchase_date = filter_input(INPUT_POST, 'purchase_date');
			$store_name = filter_input(INPUT_POST, 'store_name');
			$disk_number = filter_input(INPUT_POST, 'disk_number', FILTER_VALIDATE_INT);
			$disk_price = filter_input(INPUT_POST, 'disk_price', FILTER_VALIDATE_FLOAT);
			$disk_format = filter_input(INPUT_POST, 'disk_format');

			// Loop to handle information for 1 to 3 movies
			for ($i = 1; $i <= 3; $i++) {
				$movie_title = filter_input(INPUT_POST, "movie_title_$i");
				$movie_genre = filter_input(INPUT_POST, "movie_genre_$i");
				$movie_year = filter_input(INPUT_POST, "movie_year_$i", FILTER_VALIDATE_INT);
				$imdb_rating = filter_input(INPUT_POST, "imdb_rating_$i");
				$actors = filter_input(INPUT_POST, "actors_$i");

				// Check if movie title exists in the collection
				$check_movie_query = "SELECT * FROM MovieInfo WHERE title = '$movie_title'";
				$result_movie = $db->query($check_movie_query);

				if ($result_movie->num_rows == 0) {
					// Add New Purchase Entry
					$add_purchase_query = "INSERT INTO Purchase (pdate, sname) VALUES ('$purchase_date', '$store_name')";
					$db->query($add_purchase_query);

					// Movie doesn't exist, proceed with adding new movie
					$add_movie_query = "INSERT INTO MovieInfo (title, year, imdbRating, actors) 
										VALUES ('$movie_title', $movie_year, '$imdb_rating', '$actors')";
					if ($db->query($add_movie_query) === TRUE) {
						$newCode = $db->insert_id;

						// Insert genres into MovieGenre table
						$genres = explode(",", $movie_genre);
						foreach ($genres as $genre) {
							$add_genre_query = "INSERT INTO MovieGenre (movCode, genre) VALUES ($newCode, '$genre')";
							$db->query($add_genre_query);
						}

						// Add New Disk Entry (if it doesn't exist)
						$add_disk_query = "INSERT INTO Disks (dnum, price, format, status, isDigit, isDisk)  
										   VALUES ($disk_number, $disk_price, '$disk_format', 'A', 0, 1)";
						$db->query($add_disk_query);

						// Associate Movie with Disk
						$associate_movie_disk_query = "INSERT INTO DiskMovies (dnum, movCode) VALUES ($disk_number, $newCode)";
						$db->query($associate_movie_disk_query);

						// Get the Purchase Number for the Newly Created Purchase
						$get_purchase_number_query = "SELECT max(pno) as latest_purchase FROM Purchase";
						$result_purchase_number = $db->query($get_purchase_number_query); 
						$row = $result_purchase_number->fetch_assoc();
						$pno = $row['latest_purchase'];

						// Add Purchase Details
						$add_purchase_details_query = "INSERT INTO PurchDetails VALUES ($pno, $disk_number)";
						$db->query($add_purchase_details_query);
						
						echo "<script>alert('Purchase for Movie $i was added to your collection!');</script>";
					} else {
						echo "Error: " . $add_movie_query . "<br>" . $db->error;
					}
				} else {
					while ($row = $result_movie->fetch_assoc()) {
						echo "<script>alert('Movie $i already exists in your collection');</script>";
					}
				}
			}
		}
			// Close database connection
			$db->close();
		?>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>
