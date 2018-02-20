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
			<p class="topic">Students-Classes<p>
			<p class="subtopic">List of Students-Classes Enrollment<p>
			<table align="center">
				<tr>
					<th>STUDENT NAME
					<th>CLASS
					<th>GRADE
				</tr>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT Students.FirstName, Students.LastName, Classes.Name, Classes.Level, Students_classes.Grade FROM Students_classes INNER JOIN Students ON Students.ID = Students_classes.Student_ID INNER JOIN Classes ON Classes.ID = Students_classes.Class_ID"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($sfname, $slname, $cname, $clevel, $grade)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					 echo "<tr>\n<td>\n" . $sfname . " " . $slname . "\n</td>\n<td>\n" . $cname . " " . $clevel . "\n</td>\n<td>\n" . $grade . "\n</td>\n</tr>";
				}
				$stmt->close();
				?>
			</table>
			<p>
			
			<!--add to hogwarts enrollment--> 
			<p class="subtopic">Add a New Student-Class Enrollment<p>
			<form method="post" action="addsc.php">
				<fieldset>
					<legend>NEW ENROLLMENT</legend>
					<p class="content">Student: <br>
					<select name="Student_ID">
						<?php
						if(!($stmt = $mysqli->prepare("SELECT ID, FirstName, LastName FROM Students"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $fname, $lname)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $fname . " " . $lname . '</option>\n';
						}
						$stmt->close();
						?>
					</select>
					<p class="content">Classes: <br>
					<select name="Class_ID">
						<?php
						if(!($stmt = $mysqli->prepare("SELECT ID, Name, Level FROM Classes"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $cname, $clevel)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $cname . " " . $clevel . '</option>\n';
						}
						$stmt->close();
						?>
					</select>
					<p class="content">Current Grade: <br>
					<select name="Grade">
						<option value="Outstanding">O - Outstanding</option>
						<option value="Exceeds Expectations">E - Exceeds Expectations </option>
						<option value="Acceptable">A - Acceptable</option>
						<option value="Poor">P - Poor</option>
						<option value="Dreadful">D - Dreadful </option>
						<option vaue="Troll">T - Troll</option>
					</select>
					<p>
					<input type="submit" name="add" value="Add New Enrollment" />
				</fieldset>
			</form>
		</div>
	</body>
</html>

