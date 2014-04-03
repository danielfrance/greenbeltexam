<?php
session_start();
include('new-connection.php');

	if (isset($_POST['action']) && $_POST['action'] =="register")
	    {
		
	    	register_user($_POST);



		}
	elseif (isset($_POST['action']) && $_POST['action'] =="add_expense" ) 
	{
		add_expenses($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'delete' ) 
	{
		delete_expense($_POST);
	}
	// else 
	// {
	// 	session_destroy();
	// 	header('location: index.php');
	// 	die();
	// }

// ///////////////
		function register_user($post)
		{
			$_SESSION['errors'] = array();

			if (empty($post['first_name'])) 
			{
				$_SESSION['errors'][] = "sorry brah, the NSA needs your first name";
			}

			if (empty($post['budget'])) 
			{
				$_SESSION['errors'][] ="we'll need your monthly budget too";
			}
			if (count($_SESSION['errors']) > 0) 
			{
				header('location:index.php');
				die();
			}
			
			else
			{
				$name= escape_this_string($post['first_name']);
				$budget= escape_this_string($post['budget']);
				$query= "INSERT INTO users (first_name, budget, created_at, updated_at )
							VALUES	( '{$name}', '{$budget}', NOW(), NOW() )";
				// run_mysql_query($query);
				unset($_SESSION['errors']);

				$_SESSION['message'] = "you've successfully registered!";


				$_SESSION['user_id'] = run_mysql_query($query);  // seriously, how did I do this? I'm not even mad.  


				header('location: tracker.php?='.$_SESSION['user_id']);
				die();

			}

		}

//////////////////

		function add_expenses($post)
		{
			$_SESSION['errors']=array();

			if (empty($post['particulars'])) 
			{
					$_SESSION['errors'][]="sorry, please give a description";
			}
			if (empty($post['amount'])) 
			{
				$_SESSION['errors'][] = "sorry, please give an amount";
			}
			if (count($_SESSION['errors']) > 0) 
			{
				header('location:tracker.php');
				die();
			}
			else
			{
				$particulars = escape_this_string($post['particulars']);
				$amount = escape_this_string($post['amount']);
				$query="INSERT INTO expenses (users_id,particulars, amount, created_at, updated_at)
						VALUES ({$_SESSION['user_id']}, '{$particulars}', '{$amount}', NOW(), NOW() )";
				
				run_mysql_query($query);
				header('location: tracker.php');
		
			}

		}

/////////////////////
		function delete_expense($post)
		{
			if (isset($post)) 
			{
				$query = "DELETE FROM expenses
						  WHERE expenses.id = {$post['expenses_id']} ";

				run_mysql_query($query);
				header('location:tracker.php');
				// var_dump($query);
				// die();
			}
		

		}







  ?>