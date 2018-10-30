<?php

include_once '../../config/Database.php';
include_once '../../models/Login.php';

$database = new Database();
$db = $database->connect();

$response = array("error" => FALSE);
 
if (isset($_POST['user_name']) && isset($_POST['email']) && isset($_POST['password'])) {
 
    
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // Cek jika user ada dengan email yang sama
    if ($db->isUserExisted($email)) {
        // user telah ada
        $response["error"] = TRUE;
        $response["error_msg"] = "User telah ada dengan email " . $email;
        echo json_encode($response);
    } else {
        // buat user baru
        $user = $db->simpanUser($user_name, $email, $password);
        if ($user) {
            // simpan user berhasil
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["user_name"] = $user["user_name"];
            $response["user"]["email"] = $user["email"];
            echo json_encode($response);
        } else {
            // gagal menyimpan user
            $response["error"] = TRUE;
            $response["error_msg"] = "Terjadi kesalahan saat melakukan registrasi";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Parameter (user_name, email, atau password) ada yang kurang";
    echo json_encode($response);
}
?>