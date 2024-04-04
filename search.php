<?php
session_start();

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
	Filename: search.php
	Purpose: allows users to search database by keywoord in name, actor, or genre -->
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
				/* Text color */
			}

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
			<div class="current-page">SEARCH MOVIES</div> 
		</div>
		<!-- Search Form Section -->
		<form method="GET" action="">
        <label for="search_by" style = "color:#ffd166;">Search By:</label>
			<select name="search_by" id="search_by">
				<option value="keyword">Keyword</option>
				<option value="genre">Genre</option>
				<option value="actor">Actor</option>
			</select>
			<input type="text" name="search_term" placeholder="Enter search term">
			<button type="submit">Search</button>
		</form>
		<div class="container">
			<table> 
			<?php
			include 'mylib.php';

			$conn_error = db_connect();
			if ($conn_error !== null) {
				die("Connection failed: " . $conn_error);
			}

			$search_by = isset($_GET['search_by']) ? $_GET['search_by'] : 'keyword';
			$search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';

			if (isset($_GET['search_by']) && isset($_GET['search_term'])) {
				$search_by = $_GET['search_by'];
				$search_term = $_GET['search_term'];

				switch ($search_by) {
					case 'keyword':
						$query = "SELECT dnum, isDigit, isDisk, title, year, imdbrating, actors, price,
									format, status
									FROM Disks NATURAL JOIN DiskMovies JOIN MovieInfo ON code = movCode
									WHERE title LIKE '%$search_term%'
									ORDER BY dnum, title";
						break;
					case 'genre':
						$query = "SELECT dnum, isDigit, isDisk, title, year, imdbrating, actors, genre,
									price, format, status
									FROM Disks NATURAL JOIN DiskMovies JOIN MovieInfo ON code = movCode NATURAL
									JOIN MovieGenre
									WHERE genre LIKE '%$search_term%'
									ORDER BY dnum, title";
						break;
					case 'actor':
						$query = "SELECT dnum, isDigit, isDisk, title, year, imdbrating, actors, price,
									format, status
									FROM Disks NATURAL JOIN DiskMovies JOIN MovieInfo ON code = movCode
									WHERE actors LIKE '%$search_term%'
									ORDER BY dnum, title";
						break;
				}

				$result = $db->query($query);
				
				if ($result && $result->num_rows > 0) {
					echo '<table border="1">
							<tr>
								<th>Disk Number</th>
								<th>Digital</th>
								<th>On Disk</th>
								<th>Movie Title</th>
								<th>Year</th>
								<th>IMDB Rating</th>
								<th>Actors</th>
								<th>Disk Price</th>
								<th>Format</th>
								<th>Status</th>
							</tr>';

					while ($row = $result->fetch_assoc()) {
						echo '<tr>
								<td>' . $row['dnum'] . '</td>
								<td>' . ($row['isDigit'] ? 'Yes' : 'No') . '</td>
								<td>' . ($row['isDisk'] ? 'Yes' : 'No') . '</td>
								<td>' . $row['title'] . '</td>
								<td>' . $row['year'] . '</td>
								<td>' . $row['imdbrating'] . '</td>
								<td>' . $row['actors'] . '</td>
								<td>' . $row['price'] . '</td>
								<td>' . $row['format'] . '</td>
								<td>' . $row['status'] . '</td>
							</tr>';
					}

					echo '</table>';
				} else {
					echo "No results found";
				}

				$db->close();
			}
			?>
		</table>
		</div>
		<!-- Disclaimer Section -->
		<p class="disclaimer">
			<i>This project is FOR EDUCATIONAL PURPOSES ONLY and is NOT an actual store.</i>
			Created by <a href="../../index.php">Kate Fedotova</a>
		</p>
	</body>
</html>