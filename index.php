<?php 
    // initialize variable
	$errors = "";
	$server = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mytodolist";
	// connect to database
	$db = mysqli_connect($server, $username, $password, $dbname);

	// insert a task if clicked add button 
	if (isset($_POST['add'])) {
		//$errors = $_POST['submit'];
		//echo $errors;
		if (empty($_POST['newtask'])or empty($_POST['newstatus']) or empty($_POST['newdueday']) ) {
			$errors = "You must fill all information for the task";
			//$errors = $_POST['submit'];
		}
		else{
			//$errors = "get task";
			$task = $_POST['newtask'];
			$status=$_POST['newstatus'];
			$dueday=$_POST['newdueday'];
			$eid = $_POST['neweid'];
			$sql = "INSERT INTO tasks (task, status, dueday, eid) VALUES ('$task', '$status', '$dueday', '$eid')";  //insert statement 
			$query = mysqli_query($db, $sql);  //execute insert to database 
			//if ($query)
				//echo 'query success';
			header('location: index.php');
		}

	}
	if (isset($_POST['delall'])) {

		//$errors = "del all";
		$sql = "DELETE FROM tasks";  //delete statement 
		//echo $sql;
		$query = mysqli_query($db, $sql);  //execute insert to database 
		header('location: index.php');
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
		<h2 style="font-style: 'Arial';">ToDo List Application </h2>
	</div>

	<div class="heading">
		<h3 style="font-style: 'Arial';">All Existing Tasks </h3>
	</div>	
	<!!!retrieve information from the database and display them. >
	<table>
	  <thead>
		<tr>
			<th style="width: 30px;" align="left">ID</th>  <!header>
			<th style="width: 260px;" align="left">Task</th>
			<th style="width: 140px;" align="left">Status</th>
			<th style="width: 250px;" align="left">Due Date</th>	
			<th style="width: 100px;" align="left">Assignee</th>
			<th style="width: 30px;" align="left">Action</th>
		</tr>
	  </thead>

	 <tbody>
		<?php 
		//  visit the task table in database//
		$tasks = mysqli_query($db, "SELECT * FROM tasks"); //select statement


		$i = 1; while ($row = mysqli_fetch_array($tasks)) { 
			$emploees = mysqli_query($db, "SELECT * FROM employees WHERE eid=".$row['eid']);
			$emp = mysqli_fetch_array($emploees);
		?>
			<tr>                                              <!row>
				<td> <?php echo $i; ?> </td>
				<td class="task">
					<a href="task.php?task_id=<?php echo $row['id'] ?>"><?php echo $row['task']; ?> </a>
				</td>
				<td class="status"> <?php echo $row['status']; ?> </td>
				<td class="dueday"> <?php echo $row['dueday']; ?> </td>				
				<td class="assignee"> <?php echo $emp['name']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">Delete</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	 </tbody>
    </table>
	
	
	<form method="post" action="index.php" class="input_form">
	<!!!if no task was filled in the form, the value of the $errors variable is set >
	<?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
    <?php } ?>
	
		Task:<input style="width: 210px;" type="text" name="newtask" class="task_input">
		Status:<input style="width: 75px;" type="text" name="newstatus" class="status_input">
		Due Date:<input style="width: 90px;" type="text" name="newdueday" class="dueday_input">
		Assign to(EmployeeID):<input style="width: 90px;" type="text" name="neweid" class="eid_input">
		<input type="submit" name="add" id="add_btn" class="add_btn" value="Add">
		<br>
		<br>
		<input type="submit" name="delall" id="del_btn" class="del_btn" value = "Delete All Tasks">
	</form>
</body>
</html>