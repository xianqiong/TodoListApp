<?php 
    // initialize errors variable
	$errors = "";
	// connect to database
	$db = mysqli_connect("localhost", "root", "", "mytodolist");
	$dispid = "";
	$disptask = "";
	$dispstatus = "";
	$dispdueday = "";
	//find task
	if (isset($_GET['task_id'])) {
		$dispid = $_GET['task_id'];
		//update information in database
		if (isset($_POST['save'])) {
			if (empty($_POST['newtask']) or empty($_POST['newstatus']) or empty($_POST['newdueday']) ) {
				$errors = "You must fill all information in the task";
			}
			else{
				$task = $_POST['newtask'];
				$status=$_POST['newstatus'];
				$dueday=$_POST['newdueday'];
				$sql ="UPDATE tasks SET task='$task', status='$status', dueday='$dueday' WHERE id =".$dispid;
				//echo $sql;
				$query = mysqli_query($db, $sql);  //execute update to database 
				
				//header('location: task.php');
			}
			
		}	
	}
	if (isset($_POST['return']))
	{
		header('location: index.php');
		//echo "I should return";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Task</title>
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Arial';">Task Information </h2>
	</div>
	
	<?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
    <?php } ?>
	
	<?php if (isset($_GET['task_id'])) { 
		$dispid = $_GET['task_id'];
		$tasks = mysqli_query($db, "SELECT * FROM tasks WHERE id=".$dispid);
		$row = mysqli_fetch_array($tasks);
		$disptask = $row['task'];
		$dispstatus = $row['status'];
		$dispdueday = $row['dueday'];
	?>	
	<form method="post" action="task.php?task_id=<?php echo $dispid?>" class="input_form">

		Task:    <input type="text" name="newtask" class="task_input" value="<?php echo $disptask?>"><br><br>
		Status:  <input type="text" name="newstatus" class="status_input" value="<?php echo $dispstatus?>"><br><br>
		Due Date:<input type="text" name="newdueday" class="dueday_input" value="<?php echo $dispdueday?>">
		<br><br>
		<button type="save" name="save" id="save_btn" class="save_btn">Save</button>
		<br><br>
		<button type="return" name="return" id="return_btn" class="return_btn">Return</button>
	
	</form>
	<?php } ?>
</body>
</html>