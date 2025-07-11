<?php
include "../dbcon.php";
$imgarray=[];
if(isset($_FILES["documents"]["name"]))
{
    $total = count($_FILES["documents"]["name"]);
    for( $i=0 ; $i < $total ; $i++ ) {
        $path_parts = pathinfo($_FILES["documents"]["name"][$i]);
        $image_path = 'photos_'.$i.time().'.'.$path_parts['extension'];
      $response['file_name'] = basename($_FILES['documents']['name'][$i]);
      $result=[];
      
      $desired_dir="../empdoc";
      if(is_dir($desired_dir)==false)
      {
        mkdir("$desired_dir", 0700);
      }
      if(is_dir("$desired_dir/".$image_path)==false){
        move_uploaded_file($_FILES['documents']['tmp_name'][$i],"$desired_dir/".$image_path);
      }else{									
        $new_dir="$desired_dir/".$image_path.time();
        rename($_FILES['documents']['tmp_name'][$i],$new_dir);
      }
      array_push($imgarray,$image_path);
    }
}

$json = json_encode($_POST);

$updateid="";
$tablename="";

$subquery="";
foreach($_POST as $key => $val) {
    if($key=="updateid")
    $updateid=$val;
    if($key=="tablename")
    $tablename=$val;
    if($key!="updateid" && $key!="tablename")
    $subquery.=$key."='$val',";
}

$subquery=substr($subquery,0,strlen($subquery)-1);

$imagequery="";

if(count($imgarray)>0)
{
    $imgjson=json_encode($imgarray);
    $imagequery=",documents='$imgjson'";
}
$query="UPDATE $tablename SET $subquery $imagequery where id='$updateid'";

$result=[];

if(mysqli_query($conn,$query))
{
    $result["message"]="Updated Successfully";
    $result["status"]=true;
}
else{
    $result["message"]="Something Went Wrong";
    $result["status"]=false;
}

echo json_encode($result);
mysqli_close($conn);

?>