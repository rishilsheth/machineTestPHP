<?php
//update.php

include('dbconfig.php');
echo $_POST["product_id"];

$id=$_POST['product_id'];
$name=$_POST['product_name'];
$price=$_POST['product_price'];
$desc=$_POST['product_description'];

$query = "UPDATE `produce` 
SET `product_name`='$name',
`product_price`='$price',
`product_description`='$desc' WHERE id=$id";
$result = $conn->query($query);

?>