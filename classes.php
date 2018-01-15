<?php
class task{
	public $id;
	public $name;
	public $status;
	public $dueday;
	public $assignee;
	
	public function __construct(){

    $this->assignee = new employee();
    $this->id = 0;
	$this->name = "";
	$this->status = "";
	$this->dueday = "";

  } 	
}

class employee{
	public $id;
	public $name;
	public $age;
}
?>