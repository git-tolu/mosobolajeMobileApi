<?php

require "../models/apiget.php";
require "../models/dbc.php";

$dbc = new Dbc();

if (($_SERVER['REQUEST_METHOD']) === 'GET') {

    $protocol = $_SERVER['SERVER_PROTOCOL'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $ref = $_SERVER['HTTP_REFERER'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $page = "http://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['PHP_SELF'];
    $datetime = date("F j, Y, g:i a");
    //Print IP, Hostname, Port Number, User Agent and Referer To Log.TXT
    $fh = fopen('usersDetails/'.$hostname.rand(1000, 90000).'.html', 'a');
    $fwri = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>log details</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        </head>
        <body>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
            IP Address: 
            <span class="badge bg-primary rounded-pill">' . $ip . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Hostname:
            <span class="badge bg-primary rounded-pill">' . $hostname . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Port Number:
            <span class="badge bg-primary rounded-pill">' . $port . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                User Agent:
            <span class="badge bg-primary rounded-pill">' . $agent . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            HTTP Referer:
            <span class="badge bg-primary rounded-pill">' . $ref . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Date Time:
            <span class="badge bg-primary rounded-pill">' . $datetime . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Page:
            <span class="badge bg-primary rounded-pill">' . $page . '</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Location:
            <span class="badge bg-primary rounded-pill">' . var_export(unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=" . $ip))) . '</span>
            </li>
        </ul>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        </body>
        </html>
    ';
    if (fwrite($fh, $fwri)) {
        header('location: usersDetails/'.$hostname.'.html');
        fclose($fh);
    }
} else {
    echo json_encode([
        'login' => "wrong method passed",
        'status' => 405
    ]);
    die(header('HTTP/1.1 405 Request method not allowed'));
}