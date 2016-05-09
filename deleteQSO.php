<?php
include('config.php');
if(isset($_GET['id'])) {
	$id=$_GET['id'];
	$query1=mysql_query("DELETE FROM qso where id='$id'");
	if($query1) {
		header('location:search.php?mode=search');
	}
}
?>
