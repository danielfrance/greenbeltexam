<?php
session_start();
include('new-connection.php');




  ?>
  <html>
  <head>
  	<title>Your Expenses</title>
  </head>
  <body>
  	<div id="main-content">
  		<div id="header">
  			<?php
  			$budget_query = "SELECT budget
  							FROM users
  							where id = {$_SESSION['user_id']} ";

  			$budget_result = fetch_record($budget_query);
  			
  			echo "you're total monthly budget is  {$budget_result['budget']}";

  			
	  		
	  		$remainder_query = "SELECT budget - sum(amount) as remainder
								FROM expenses
								LEFT JOIN users on expenses.users_id = users.id
								WHERE users.id = {$_SESSION['user_id']}";

			$remainder_result = fetch_record($remainder_query); 
			// var_dump($remainder_result);
      if (!$remainder_result['remainder'] == null) 
      {
        echo "<p>you have {$remainder_result['remainder']} left in your budget";
      }


  		 	
  			


  			  ?>
  			
  		</div>
  		<?php
  			if (isset($_SESSION['message'])) 
  			{
  				echo $_SESSION['message'];
  				unset($_SESSION['message']);
  			}


  			$query="SELECT first_name
  					FROM users
  					where id = {$_SESSION['user_id']}";
  			$name_query=fetch_record($query);

  			echo "<h1>Welcome {$name_query['first_name']}</h1>  ";
  		  ?>
  		
  		<h5>List of Expense</h5>
  		<div id="table">
	  		<table>
	  			<thead>
	  				<tr>
	  					<th>date</th>
	  					<th>Particulars</th>
	  					<th>Amount</th>
	  					<th>Action</th>
	  				</tr>
	  			</thead>
	  			<tbody>
	  				
	  				<?php
	  					$expenses_query = "SELECT * 
	  										FROM expenses
	  										where users_id = {$_SESSION['user_id']} ";
	  					$expenses_result = fetch_all($expenses_query);
	  					
	  					// var_dump($expenses_result);
	  					
	  					
	  					foreach ($expenses_result as $key) 
	  					{
	  						echo "<tr><td>" . date('F d, Y', strtotime($key['updated_at']))  . "</td> 
	  						<td>{$key['particulars']}</td> 
	  						<td>{$key['amount']}</td>
	  						<td> 
	  							<form method='post' action='process.php'>
	  								<input type='hidden' name='expenses_id' value='{$key['id']}'>
	  								<input type='hidden' name='action' value='delete'>
	  								<input type='submit' name='delete_record' value='Remove'>
	  							</form>
	  							</tr>";
	  						
	  					}

	  					

	  					
	  					

	  				  ?>
	  			</tbody>
	  		</table>
  		</div>
  		<div>
  			<?php
  				if (isset($_SESSION['errors'])) 
  				{
  					foreach ($_SESSION['errors'] as $error) 
  					{
  						echo "<p>" . $error;
  					}
  				}

  			  ?>
  			<form action="process.php" method="post">
  				<input type="hidden" name="action" value="add_expense">
  				<label>Expense</label>
  				<input type="text" name="particulars">
  				<label>Amount</label>
  				<input type="text" name="amount">
  				<input type="submit" value="Add">
  			</form>
  		</div>

  	</div>
  
  </body>
  </html>