<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "abcd";
    $db = "machinetest";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
    
    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}
$conn = OpenCon();

if($conn === false)
{
    die("ERROR: Could not connect. " . $conn->connect_error);
}
// else
// {
//     echo "Connected Successfully<br>";
// }
$sql = "CREATE TABLE if not exists produce(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(30) NOT NULL,
    product_price VARCHAR(30) NOT NULL,
    product_description VARCHAR(256)
    )";

$sql1 = "CREATE TABLE if not exists images(
    id INT,
    image VARCHAR(30),
    FOREIGN KEY (id) REFERENCES produce(id)
    )";

// if($conn->query($sql1) === true)
// {
//     echo "Table created successfully.<br>";
// }
// else
// {
//     echo "ERROR: Could not able to execute $sql. " . $conn->error;
// }

?>