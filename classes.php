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
			<p class="topic">Classes<p>
			<p class="subtopic">List of Hogwarts Classes<p>
			<table align="center">
				<tr>
					<th>CLASS
					<th>LEVEL
					<th>PROFESSOR
				</tr>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT Classes.name, Classes.level, Professors.LastName FROM Classes INNER JOIN Professors ON Professors.ID = Classes.Professor_ID"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($name, $level, $professor)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . " Year " . $level . "\n</td>\n<td>\n" . $professor . "\n</td>\n</tr>";
				}
				$stmt->close();
				?>
			</table>
			<p>
			<!--add to Classes table--> 
			<p class="subtopic">Add a New Class<p>
			<form method="post" action="addclass.php">
				<fieldset>
					<legend>NEW CLASS</legend>
					<p class="content">Class Name: <br><input type="text" name="Name" /></p>
					<p class="content">Grade Level (1-7): <br><input type="number" name="Level" /></p>
					<p class="content">Professor: <br>
					<select name="Professor_ID">
						<?php
						if(!($stmt = $mysqli->prepare("SELECT ID, LastName FROM Professors"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $pname)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
						}
						$stmt->close();
						?>
					</select>
					<p>
					<input type="submit" name="add" value="Add New Class" />
				</fieldset>
			</form>
		</div>
	</body>
</html>