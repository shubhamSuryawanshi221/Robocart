<?php
    
    require("../dbcon.php");

    $tablename=$_POST["tablename"];
    $id=$_POST["id"];

    $query="delete from $tablename where id='$id'";

    $result=[];

    if(mysqli_query($conn,$query))
    {
        $result["message"]="Deleted Successfully";
        $result["status"]=true;
    }
    else{
        $result["message"]="Something Went Wrong";
        $result["status"]=false;
    }
    
    echo json_encode($result);
    mysqli_close($conn);

?>