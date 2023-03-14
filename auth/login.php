<?php
require "../models/apipost.php";
require "../models/dbc.php";

$dbc = new Dbc();

if (($_SERVER['REQUEST_METHOD']) === 'POST') {

    // echo json_encode([
    //     'msg' => password_hash('12345', PASSWORD_DEFAULT),
    // ]);
    // die();

    if ($dbc->validateInput($_POST['username'])) {
        $username = $dbc->test_input($_POST['username']);
    } else {
        echo json_encode([
            'login' => 'username cannot be empty',
            'status' => 403
        ]);
        die();
    }

    if ($dbc->validateInput($_POST['password'])) {
        $password = $dbc->test_input($_POST['password']);
        // if ($dbc->passwordRegex($password)) {
        //         echo json_encode([
        //         'login' => $dbc->passwordRegex($password),
        //         'status' => 403
        //     ]);
        //     die();
        // }
    } else {
        echo json_encode([
            'login' => 'password cannot be empty',
            'status' => 403
        ]);
        die();
    }

    $login = $dbc->login($username);

    if ($login != null) {
        if (password_verify($password, $login['password'])) {
            $_SESSION['ourUser'] = $username;
            if($_SESSION['ourUser']){
                echo json_encode([
                    'login' => 'Successful',
                    'user_id'=> $login['username'],
                    'paddress'=> $login['paddress'],
                    'fullname'=> $login['fullname'],
                    'email'=> $login['emailaddress'],
                    'status' => 200
                ]);
                die();
            }else{
                echo json_encode([
                    'login' => 'Something went wrong try again later',
                    'status' => 400
                ]);
                die();
            }
        } else {
            echo json_encode([
                'login' => 'Invalid username or password',
                'status' => 400
            ]);
            die();
        }
    } else {
        echo json_encode([
            'login' => 'User not found',
            'status' => 400
        ]);
        die();
    }
} else {
    echo json_encode([
        'login' => "wrong method passed",
        'status' => 405
    ]);
    die(header('HTTP/1.1 405 Request method not allowed'));
}




// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['username'];
//     $password = $_POST['password'];


//     $sql = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
//     $result= mysqli_query($conn, $sql);
//     $fetch = mysqli_fetch_assoc($result);
    
//     // If there is one row, the user is authenticated
//     if ($result) {
//         $response = array('status' => 'success', 'message' => 'Login successful');
//     } else {
//         $response = array('status' => 'error', 'message' => 'Invalid username or password');
//     }

//     echo json_encode($response);
// }

