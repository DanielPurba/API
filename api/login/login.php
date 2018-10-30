<?php

include_once '../../config/Database.php';
include_once '../../models/Login.php';

$database = new Database();
$db = $database->connect();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['email']) && isset($_POST['password'])) {
 
   
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    
    $user = $db->getUserByEmailAndPassword($email, $password);
 
    if ($user != false) {
        
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["user_name"] = $user["user_name"];
        $response["user"]["email"] = $user["email"];
        echo json_encode($response);
    } else {
      
        $response["error"] = TRUE;
        $response["error_msg"] = "Login gagal. Password/Email salah";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Parameter (email atau password) ada yang kurang";
    echo json_encode($response);
}
?>