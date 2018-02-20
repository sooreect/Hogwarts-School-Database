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
			<p class="topic">Students<p>
			<!--display search results--> 
			<p class="subtopic">Search Results:<p>
			<table align="center">
				<tr>
					<th>FIRST NAME
					<th>LAST NAME
					<th>GENDER
					<th>DATE OF BIRTH
					<th>BLOOD STATUS
					<th>HOUSE
				</tr>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT Students.FirstName, Students.LastName, Students.Gender, Students.DOB, Students.BloodStatus, Houses.Name FROM Students INNER JOIN Houses ON Houses.Id = Students.House_ID WHERE Students.LastName = ?"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("s",$_POST['LastName']))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($fname, $lname, $gender, $dob, $blood, $house)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $gender ."\n</td>\n<td>\n" . $dob ."\n</td>\n<td>\n" . $blood ."\n</td>\n<td>\n" . $house . "\n</td>\n</tr>";
				}
				$stmt->close();
				?>
			</table>
			<p>
		</div>
	</body>
</html>




