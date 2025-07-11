<?php
include "../dbcon.php";

$id=$_POST["id"];
$tablename=$_POST["tablename"];

$res=mysqli_query($conn,"select * from $tablename where id='$id'");

$row=mysqli_fetch_assoc($res);


echo json_encode($row);
mysqli_close($conn);
?>