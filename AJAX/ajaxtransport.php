<?php
    
    require("../dbcon.php");

    $tablename=$_POST["tablename"];

    $query="select  id,`trname`, `contctno`, `email`, `fr_description`, `pincode`, `gstin`,rc_file  from transport";

    $result=mysqli_query($conn,$query);
    $output="";
    
    while($row=mysqli_fetch_assoc($result))
    {

        $output.="<tr>"; 
        $output.='<td>'.json_decode($row["trname"], true).'</td>';  
        $output.='<td>'.json_decode($row["fr_description"], true).'</td>';  
        $output.='<td>'.json_decode($row["pincode"], true).'</td>';  
        $output.='<td>'.json_decode($row["contctno"], true).'</td>';  
        $output.='<td>'.count(json_decode($row["rc_file"], true)).'</td>'; 
        $output.='<td>true</td>'; 
        /*foreach ($row as $key => $value) {
            if($key!="documents")
            $output.='<td>'.json_decode($value, true)[0].'</td>';  
        }*/
        $output.='<td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="./cc_update_transporter.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                        <button onclick="deletefn('.$row["id"].')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i> Delete</button>
                      </div>
                    </td></tr>';
                    
    }
    echo $output;
    mysqli_close($conn);
?>