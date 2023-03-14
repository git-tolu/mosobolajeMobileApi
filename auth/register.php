<?php

require "../models/apipost.php";
require "../models/dbc.php";


$dbc = new Dbc();

if (($_SERVER['REQUEST_METHOD']) === 'POST') {

    if ($dbc->validateInput($_POST['newUserName'])) {
        $newUserName = $dbc->test_input($_POST['newUserName']);
    } else {
        echo json_encode([
            'nameerr' => 'name cannot be empty',
            'status' => 403
        ]);

        die();
    }

    if ($dbc->validateInput($_POST['newUserEmail'])) {
        $newUserEmail = $dbc->test_input($_POST['newUserEmail']);
    } else {
        echo json_encode([
            'emailerr' => 'email cannot be empty',
            'status' => 403
        ]);
        die();
    }

    if ($dbc->validateInput($_POST['newUserPassword'])) {
        $newUserPassword = $dbc->test_input($_POST['newUserPassword']);
        $hash = password_hash($newUserPassword, PASSWORD_DEFAULT);
        if ($dbc->passwordRegex($newUserPassword)) {
            echo json_encode([
                'passworderr' => $dbc->passwordRegex($newUserPassword),
                'status' => 403
            ]);
            die();
        }
    } else {
        echo json_encode([
            'passworderr' => 'password cannot be empty',
            'status' => 403
        ]);
        die();
    }

    if ($dbc->validateInput($_POST['newUserConfirmPassword'])) {
        $newUserConfirmPassword = $dbc->test_input($_POST['newUserConfirmPassword']);
        if ($dbc->passwordRegex($newUserConfirmPassword)) {
            echo json_encode([
                'confirmPassworderr' => $dbc->passwordRegex($newUserConfirmPassword),
                'status' => 403
            ]);
            die();
        }
    } else {
        echo json_encode([
            'confirmPassworderr' => 'Confirm password cannot be empty',
            'status' => 403
        ]);
        die();
    }


    if ($dbc->emailCheck($newUserEmail)) {
        echo json_encode([
            'emailerr' => 'email already exists',
            'status' => 403
        ]);
        die();
    } else {
        if ($newUserPassword !== $newUserConfirmPassword) {
            echo json_encode([
                'confirmPassworderr' => 'Passwords do not match',
                'status' => 403
            ]);
            die();
        } else {
            if (!empty($newUserName) && !empty($newUserEmail) && !empty($newUserPassword) && !empty($newUserConfirmPassword)) {
                $result = $dbc->registerUser($newUserName, $newUserEmail, $hash);
                if ($result) {
                    $_SESSION['u'] = $newUserEmail;
                    echo json_encode([
                        'result' => 'Successfull',
                        'status' => 200
                    ]);
                    die();
                } else {
                    echo json_encode([
                        'resulterr' => 'Sorry something went wrong',
                        'status' => 403
                    ]);
                    die();
                }
            }
        }
    }
} else {
    echo json_encode([
        'message' => "wrong method passed",
        'status' => 405
    ]);
    die(header('HTTP/1.1 405 Request method not allowed'));
}
