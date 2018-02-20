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
			<!--use aggregate function to get Students count--> 
			<p class="subtopic">
			<?php
			if(!($stmt = $mysqli->prepare("SELECT COUNT(Students.ID) FROM Students"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			if(!$stmt->bind_result($scount)){
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			while($stmt->fetch()){
				echo "\nTotal number of students = " . $scount . "\n";
			}
			$stmt->close();
			?><p>
			<!--view Students' table contents--> 
			<p class="subtopic">List of Hogwarts Students<p>
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
				if(!($stmt = $mysqli->prepare("SELECT Students.FirstName, Students.LastName, Students.Gender, Students.DOB, Students.BloodStatus, Houses.Name FROM Students INNER JOIN Houses ON Houses.Id = Students.House_ID"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
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
			<!--search the Students table--> 
			<p class="subtopic">Search the Students Database<p>
			<form method="post" action="searchstudent.php">
				<fieldset>
					<legend>SEARCH</legend>
					<p class="content">Last Name: <br><input type="text" name="LastName" /></p>
					<p>
					<input type="submit" name="search" value="Submit" />
				</fieldset>				
			</form>
			<p>
			<!--add to Students table--> 
			<p class="subtopic">Add a New Student<p>
			<form method="post" action="addstudent.php">
				<fieldset>
					<legend>NEW STUDENT</legend>
					<p class="content">First Name: <br><input type="text" name="FirstName" /></p>
					<p class="content">Last Name: <br><input type="text" name="LastName" /></p>
					<p class="content">Gender: <br>
					<select name="Gender">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					<p class="content">Date of Birth: <br><input type="date" name="DOB" /></p>
					<p class="content">Blood Status: <br>
					<select name="BloodStatus">
						<option value="Pure-Blood">Pure-Blood</option>
						<option value="Half-Blood">Half-Blood</option>
						<option vaue="Muggle-Born">Muggle-Born</option>
					</select>
					<p class="content">House: <br>
					<select name="House_ID">
						<?php
						if(!($stmt = $mysqli->prepare("SELECT ID, Name FROM Houses"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $hname)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $hname . '</option>\n';
						}
						$stmt->close();
						?>
					</select>
					<p>
					<input type="submit" name="add" value="Add New Student" />
				</fieldset>				
			</form>
		</div>
	</body>
</html>




