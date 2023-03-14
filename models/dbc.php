<?php
session_start();
require "config.php";

class Dbc extends Database
{

    public function validateInput($param)
    {
        return (!empty($param));
    }

    public function registerUser($userName, $userEmail, $userPassword)
    {
        $sql = "INSERT INTO  users (userName, userEmail, userPassword) VALUES (:userName, :userEmail, :userPassword)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "userName" => $userName,
            "userEmail" => $userEmail,
            "userPassword" => $userPassword
        ]);

        return true;
    }

    public function emailCheck($email)
    {
        $sql = "SELECT * FROM users WHERE userEmail = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "email" => $email
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function passwordRegex($password)
    {
        
        // $uppercase = preg_match('@[A-Z]@', $password);
        // $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
    
        if (!$number || !$specialChars || strlen($password) < 6) {
            return "Password should be at least 6 characters in length and should include at least one number, and one special character.";
        }
        // if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
        //     return "Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.";
        // }
    }

    public function login($username)
    {
        // $sql = "SELECT * FROM users WHERE username = :username";
        $sql = "SELECT * FROM tenants WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "username" => $username
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function sessionSelect($userEmail)
    {
        $sql = "SELECT * FROM users WHERE userEmail = :userEmail";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'userEmail' => $userEmail
        ]);

        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetch;
    }

    public function upload($sess, $title, $author, $category, $newImage, $content){
        $sql = "INSERT INTO upload (uid, title, author, category, coverimage, content) VALUES (:uid, :title, :author, :category, :coverimage, :content)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'uid' => $sess, 
            'title' => $title, 
            'author' => $author, 
            'category' => $category, 
            'coverimage' => $newImage, 
            'content' => $content
        ]);
        return true;
    }
    public function uploadUpdate($id, $title, $author, $category, $newImage, $content){
        $sql = "UPDATE upload SET  title = :title, author = :author, category = :category, coverimage = :coverimage, content = :content WHERE id = :id ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $id, 
            'title' => $title, 
            'author' => $author, 
            'category' => $category, 
            'coverimage' => $newImage, 
            'content' => $content
        ]);
        return true;
    }
    
    public function Delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return true;
    }

    public function Status($table, $status, $id){
        $sql = "UPDATE $table SET status = $status WHERE id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return true;
    }

    public function updatePassword($userPassword, $id){
        $sql = "UPDATE `users` SET userPassword = :userPassword WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'userPassword' => $userPassword,
            'id' => $id
        ]);
        return true;
    }
    
    public function UploadFetchAll($id)
    {
        $sql = "SELECT * FROM upload WHERE uid=$id ";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function UploadFetchSingle($id)
    {
        $sql = "SELECT * FROM upload WHERE id = $id ";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    public function imageValidation($img)
    {
        $file_ext = pathinfo($img, PATHINFO_EXTENSION);
        $extensions = array("jpeg", "jpg", "png", "svg", "webp");
        $result = in_array($file_ext, $extensions);
        return $result;
    }
    public function videoValidation($img)
    {
        $file_ext = pathinfo($img, PATHINFO_EXTENSION);
        $extensions = array("mp3", "mp4");
        $result = in_array($file_ext, $extensions);
        return $result;
    }

    public function updateProfilePic($profilePic, $id){
        $sql = "UPDATE `users` SET profilePic = :profilePic WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'profilePic' => $profilePic,
            'id' => $id
        ]);
        return true;
    }

    public function UpdateProfileIno($id, $firstName, $secondName, $email, $number, $bio, $date, $month, $year){
        $sql = "UPDATE users SET  firstName = :firstName, secondName = :secondName, userEmail = :email, number = :number, bio = :bio, date = :date, mon = :month, year = :year WHERE id = :id ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $id, 
            'firstName' => $firstName, 
            'secondName' => $secondName, 
            'email' => $email, 
            'number' => $number, 
            'bio' => $bio, 
            'date' => $date,
            'month' => $month,
            'year' => $year
        ]);
        return true;
    }



}
