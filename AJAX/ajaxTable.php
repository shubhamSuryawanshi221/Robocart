<?php
    
    require("../dbcon.php");

    $tablename=$_POST["tablename"];

    $query="select * from $tablename";

    $result=mysqli_query($conn,$tablename);
    $output="";
    
    while($row=mysqli_fetch_assoc($result))
    {

        $output.="<tr>";    
        foreach ($row as $key => $value) {
            if($key!="documents")
            $output.='<td>'.$value.'</td>';  
        }
        $output.='<td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <button onclick="view('.$row["id"].')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Edit</button>
                        <button onclick="deletefn('.$row["id"].')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i> Delete</button>
                      </div>
                    </td></tr>';
                    
    }
    echo $output;
    mysqli_close($conn);
?>