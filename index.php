<?php

session_start();
include('new-connection.php');




  ?>
<!doctype HTML>
<html>
<head>
	<title>Expenses Tracker</title>
</head>
<body>
	<div>
		<?php

		 if (isset($_SESSION['errors'])) 
		 {
		 	foreach ($_SESSION['errors'] as $error ) 
		 	{
		 		echo "<p>" . $error;
		 	}
		 	unset($_SESSION['errors']);
		 }





		 ?>
			
		
		<h1>Expenses Tracker</h1>
		<form action="process.php" method="post">
			<input type="hidden" name='action' value="register">
			<input type="text" name="first_name" placeholder="Your Name">
			<input type="text" name="budget" placeholder="Your total monthly budget">
			<input type="submit" value="Submit">
		</form>
	</div>
</body>
</html>