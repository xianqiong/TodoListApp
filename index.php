<?php 
    // initialize variable
	$errors = "";
	$server = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mytodolist";
	// connect to database
	$db = mysqli_connect($server, $username, $password, $dbname);

	// insert a task if clicked submit button 
	if (isset($_POST['submit'])) {
		if (empty($_POST['newtask'])or empty($_POST['newstatus']) or empty($_POST['newdueday']) ) {
			$errors = "You must fill in the task";
			
		}
		else{
			//$errors = "get task";
			$task = $_POST['newtask'];
			$status=$_POST['newstatus'];
			$dueday=$_POST['newdueday'];
			$sql = "INSERT INTO tasks (task, status, dueday) VALUES ('$task', '$status', '$dueday')";  //insert statement 
			$query = mysqli_query($db, $sql);  //execute insert to database 
			//if ($query)
				//echo 'query success';
			header('location: index.php');
		}
	}
	
	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];
		$deletesql="DELETE FROM tasks WHERE id=".$id; //delete statment
		mysqli_query($db, $deletesql);
		header('location: index.php');
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>ToDo Application</title>
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Arial';">ToDo Application </h2>
	</div>
	<form method="post" action="index.php" class="input_form">
	
	<!!!if no task was filled in the form, the value of the $errors variable is set >
	<?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
    <?php } ?>
	
		Task:<input type="text" name="newtask" class="task_input">
		Status:<input type="text" name="newstatus" class="status_input">
		Due Date:<input type="text" name="newdueday" class="dueday_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>
	
	<!!!retrieve information from the database and display them. >
	<table>
	  <thead>
		<tr>
			<th style="width: 60px;" align="left">Number</th>  <!header>
			<th style="width: 160px;" align="left">Tasks</th>
			<th style="width: 60px;" align="left">status</th>
			<th style="width: 60px;" align="left">dueday</th>			
		</tr>
	  </thead>

	 <tbody>
		<?php 
		//  visit the task table in database//
		$tasks = mysqli_query($db, "SELECT * FROM tasks"); //select statement

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>                                              <!row>
				<td> <?php echo $i; ?> </td>
				<td class="task">
					<a href="task.php?task_id=<?php echo $row['id'] ?>"><?php echo $row['task']; ?> </a>
				</td>
				<td class="status"> <?php echo $row['status']; ?> </td>
				<td class="dueday"> <?php echo $row['dueday']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	 </tbody>
    </table>

</body>
</html>