<?php 
$uploadDir = "images/";
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
 
// If form is submitted 
if(isset($_POST['name']) && isset($_POST['price'])){ 
    // Get the submitted form data 
    $name = $_POST['name']; 
    $price = $_POST['price'];
    $desc = $_POST['desc'];
     
    // Check whether submitted data is not empty 
    if(!empty($name) && !empty($price)){
            $uploadStatus = 1; 
            include('dbconfig.php');
            $insert1 = $conn->query("INSERT INTO produce (product_name, product_price, product_description) VALUES ('$name','$price','$desc')");
            
            
            $query = "SELECT * from produce WHERE product_name='$name'AND product_price='$price'AND product_description='$desc'";
            $result3 = $conn->query($query);
            while($row = $result3->fetch_assoc())
            {
                $prodid = $row["id"];
            }
            
            // Upload file 
            if(!empty($_FILES["file"]["name"]))
            {
                for($count=0; $count<count($_FILES["file"]["name"]); $count++)
                {
                    $uploadedFile = "";
                    // File path config 
                    $fileName = basename($_FILES["file"]["name"][$count]); 
                    $targetFilePath = $uploadDir . ($_FILES["file"]["name"][$count]);//$fileName; 
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                    
                    // Allow certain file formats 
                    $allowTypes = array('jpg', 'png', 'jpeg'); 
                    if(in_array($fileType, $allowTypes))
                    {
                        // Upload file to the folder 
                        if(move_uploaded_file($_FILES["file"]["tmp_name"][$count], $targetFilePath))
                        { 
                            $uploadedFile = $fileName;
                            include_once 'dbconfig.php';
                    
                            // Insert images in the database 
                            
                            $insert = $conn->query("INSERT INTO `images`(`id`, `image`) VALUES ('$prodid', '$uploadedFile')");
                            
                            if($insert)
                            {
                                $response['status'] = 1; 
                                $response['message'] = 'Form data inserted successfully!'; 
                            }
                            else
                            {
                                $uploadStatus = 0; 
                                $response['message'] = 'Sorry, Not inserted';
                            }
                        }
                        else
                        { 
                            $uploadStatus = 0; 
                            $response['message'] = 'Sorry, there was an error uploading your file.'; 
                        } 
                    }
                    else
                    { 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.'; 
                    }
                }
            }
            else
            { 
                $response['status'] = 1; 
                $response['message'] = 'Form Submitted succesfuly without images'; 
            } 
         
    }
    else
    {
         $response['message'] = 'Please fill all the mandatory fields (product name and price).';
    } 
} 

echo json_encode($response);