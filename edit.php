<?php
//edit.php
include('dbconfig.php');

$query = "SELECT * FROM produce WHERE id = '".$_POST["id"]."'";
$result = $conn->query($query);

while($row = $result->fetch_assoc())
{
 $output['product_name'] = $row["product_name"];
 $output['product_price'] = $row["product_price"];
 $output['product_description'] = $row["product_description"];
}

echo json_encode($output);

?>