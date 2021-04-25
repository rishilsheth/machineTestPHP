<?php
//delete.php

include('dbconfig.php');
// if(!isset($_POST['product_id']))
// {
//     echo "hahahahahaha";
// }

if(isset($_POST['product_id']))
{
    $id = $_POST['product_id'];
    $query1 = "SELECT * from images WHERE id = '$id'";
    $result = $conn->query($query1);

    $flag = 0;
    while($row = $result->fetch_assoc())
    {
        $filepath = 'images/' . $row["image"];
        unlink($filepath);
        
        // array_push($imgarr, $row["image"]);
    }
    $query = "DELETE FROM produce WHERE id = '$id'";
    $result2 = $conn->query($query);
    
}

?>