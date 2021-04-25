<?php
include('dbconfig.php');

$query = "SELECT * FROM produce";
$result = $conn->query($query);

$output = '';
$output .= '
 <table class="table table-bordered table-striped">
  <tr>
   <th>ID</th>
   <th>Product name</th>
   <th>Product Price</th>
   <th>Description</th>
   <th>Images</th>
   <th>Edit</th>
   <th>Delete</th>
  </tr>
';
if($result->num_rows > 0)
{
  
  while($row = $result->fetch_assoc())
  {
    // $count = 0;
    $imgarr = array();
    // $query2 = "SELECT * FROM images WHERE id='$row["id"]'";
    $result2 = $conn->query("SELECT * FROM images WHERE id = '".$row["id"]."'");
    while($row2 = $result2->fetch_assoc())
    {
      array_push($imgarr, $row2["image"]);
    }
    if(empty($imgarr))
    {
      $output .= '
      <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["product_name"].'</td>
      <td>'.$row["product_price"].'</td>
      <td>'.$row["product_description"].'</td>
      <td>No Image</td>
      <td><button type="button" class="btn btn-warning btn-xs edit" id="'.$row["id"].'">Edit</button></td>
      <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button></td>
      </tr>
      ';
    }
    else
    {
      $output .= '
      <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["product_name"].'</td>
      <td>'.$row["product_price"].'</td>
      <td>'.$row["product_description"].'</td>
      <td>';
      for($count=0; $count<count($imgarr); $count++)
      {
        $temp = "images/$imgarr[$count]";
        $output .= '<img src="'.$temp.'" class="img-thumbnail" width="100" height="100" alt="Product Image"/>';
      }
      $output .= '</td>
      <td><button type="button" class="btn btn-warning btn-xs edit" id="'.$row["id"].'">Edit</button></td>
      <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button></td>
      </tr>
      ';
    }
    
  }
}
else
{
 $output .= '
  <tr>
   <td colspan="6" align="center">No Data Found</td>
  </tr>
 ';
}
$output .= '</table>';
echo $output;
?>