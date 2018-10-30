<?php
 
class Login {
 
    private $conn;
    private $table ='penjaga_perpustakaan';

    public $id;
    public $unique_id;
    public $user_name;
    public $email;
    public $encrypted_password;
    public $salt;
 
    public function __construct($db){
        $this->conn =$db;
    }
   
    public function simpanUser($username, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
 
        $stmt = $this->conn->prepare("INSERT INTO penjaga_perpustakaan(unique_id, user_name, email, encrypted_password, salt) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uuid, $user_name, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // cek jika sudah sukses
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM penjaga_perpustakaan WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
     public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM penjaga_perpustakaan WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
   
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // cek password jika sesuai
            if ($encrypted_password == $hash) {
                // autentikasi user berhasil
                return $user;
            }
        } else {
            return NULL;
        }
    }
 
   
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from penjaga_perpustakaan WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user telah ada 
            $stmt->close();
            return true;
        } else {
            // user belum ada 
            $stmt->close();
            return false;
        }
    }
 
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
  
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}
 
?>