<?php

require("../dbcon.php");

$json = json_encode($_POST);

$tablename="";

$subquerycolumn="";
$subqueryvalue="";

foreach($_POST as $key => $val) {
    
    if($key=="tablename")
    $tablename=$val;
    if( $key!="tablename")
    {
        $subquerycolumn.=$key.",";
        $subqueryvalue.="'$val',";
    }
    
}

$subquerycolumn=substr($subquerycolumn,0,strlen($subquerycolumn)-1);
$subqueryvalue=substr($subqueryvalue,0,strlen($subqueryvalue)-1);

$finaluery="insert into $tablename($subquerycolumn) values($subqueryvalue)";
echo $finaluery;
$result=[];
if(mysqli_query($conn,$finaluery))
{
    $result["status"]=true;
    $result["message"]="Data Inserted Successfully";
}
else{
    $result["status"]=false;
    $result["message"]="Something Went Wrong";
}

echo json_encode($result);
mysqli_close($conn);

?>