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
			<?php
			if(!($stmt = $mysqli->prepare("INSERT INTO Students (FirstName, LastName, Gender, DOB, BloodStatus, House_ID) VALUES (?,?,?,?,?,?)"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!($stmt->bind_param("sssssi",$_POST['FirstName'],$_POST['LastName'],$_POST['Gender'],$_POST['DOB'],$_POST['BloodStatus'],$_POST['House_ID']))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} else {
				echo "Success! Added " . $stmt->affected_rows . " row to Students.";
			}
			?>
		</div>
	</body>
</html>
