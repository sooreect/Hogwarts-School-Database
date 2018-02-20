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
			<p class="topic">Professors<p>
			<!--use aggregate function to get Students count--> 
			<p class="subtopic">
			<?php
			if(!($stmt = $mysqli->prepare("SELECT COUNT(Professors.ID) FROM Professors"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			if(!$stmt->bind_result($scount)){
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			while($stmt->fetch()){
				echo "\nTotal number of professors = " . $scount . "\n";
			}
			$stmt->close();
			?><p>
			<!--view Professors' table contents--> 
			<p class="subtopic">List of Hogwarts Professors<p>
			<table align="center">
				<tr>
					<th>FIRST NAME
					<th>LAST NAME
					<th>AFFILIATED HOUSE
				</tr>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT Professors.FirstName, Professors.LastName, Houses.Name FROM Professors INNER JOIN Houses ON Houses.ID = Professors.House_ID"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($fname, $lname, $house)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $house . "\n</td>\n</tr>";
				}
				$stmt->close();
				?>
			</table>
			<p>
			<!--add to Professors table--> 
			<p class="subtopic">Add a New Professor<p>
			<form method="post" action="addprofessor.php">
				<fieldset>
					<legend>NEW PROFESSOR</legend>
					<p class="content">First Name: <br><input type="text" name="FirstName" /></p>
					<p class="content">Last Name: <br><input type="text" name="LastName" /></p>
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
					<input type="submit" name="add" value="Add New Professor" />
				</fieldset>
			</form>
		</div>
	</body>
</html>




