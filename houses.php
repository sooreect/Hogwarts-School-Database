<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","sooreect-db","wQnlFEPlkwBouD2K","sooreect-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Hogwarts Database</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
		<div class="header">
			<p class="title">Hogwarts School Database</p>
			<p class="subtitle">OSU CS340 2016</p>
			<p class="author">Tida Sooreechine</p>
		</div>
		<hr />
		<div class="links">
			<p class="subtopic">View &amp; Edit Tables:  
			<a href="houses.php">Houses</a> |
			<a href="students.php">Students</a> | 
			<a href="professors.php">Professors</a> | 
			<a href="classes.php">Classes</a> |
			<a href="sc.php">Students-Classes</a>
			<p>
		</div>
		<hr />
		<div class="main">
			<p class="topic">Houses<p>
			<!--view Houses' table contents--> 
			<p class="subtopic">List of Hogwarts Houses<p>
			<table align="center">
				<tr>
					<th>NAME
					<th>ANIMAL
					<th>COLOR
					<th>LOCATION
					<th>GHOST
				</tr>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT Houses.Name, Houses.Animal, Houses.Color, Houses.Location, Houses.Ghost FROM Houses "))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($name, $animal, $color, $location, $ghost)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $animal . "\n</td>\n<td>\n" . $color . "\n</td>\n<td>\n" . $location ."\n</td>\n<td>\n" . $ghost . "\n</td>\n</tr>";
				}
				$stmt->close();
				?>				
			</table>
			<p>
			<!--add to Houses table--> 
			<p class="subtopic">Add a New House<p>
			<form method="post" action="addhouse.php">
				<fieldset>
					<legend>NEW HOUSE</legend>
					<p class="content">House Name: <br><input type="text" name="Name" /></p>
					<p class="content">Animal: <br><input type="text" name="Animal" /></p>
					<p class="content">Color: <br><input type="text" name="Color" /></p>
					<p class="content">Common Room Location: <br><input type="text" name="Location" /></p>
					<p class="content">Ghost: <br><input type="text" name="Ghost" /></p>
					<p>
					<input type="submit" name="add" value="Add New House" />
				</fieldset>
			</form>
		</div>
	</body>
</html>




