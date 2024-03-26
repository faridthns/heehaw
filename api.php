<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
header('Access-Control-Allow-Methods:  POST, PUT, GET');

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db   = "heehaw";

$host = "localhost";
$user = "heek8719_heek8719";
$pass = "5zEzH91exJNc14";
$db   = "heek8719_heehaw";

$connection = mysqli_connect($host,$user,$pass,$db);

$op = $_GET['op'];
switch($op){
    case '':normal();break;
    default:normal();break;
    case 'create' :create();break;
    case 'detail' :detail();break;
    case 'update' :update();break;
    case 'leaderboard' :leaderboard();break;
    case 'address' :address();break;
    case 'getpoint' :getpoint();break;
}

function normal(){
    global $connection;
    $sql1 = "select * from wallet order by id_user desc";
    $q1 = mysqli_query($connection,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $output[] = array(
            'id_user' => $r1['id_user'],
            'address' => $r1['address'],
            'point'  => $r1['point']
        );
    } 
    $data['data']['result'] = $output;
    echo json_encode($data); 
}

function address(){
    global $connection;
    // $address = $_GET['address'];
    $sql1 = "select address from wallet";
    $q1 = mysqli_query($connection,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $output[] = array(
            'address' => $r1['address']
        );
    } 
    $data['data']['result'] = $output;
    echo json_encode($data); 
}

function create(){
    global $connection;
    $address = $_POST['address'];
    $point = $_POST['point'];
    $msg = "cannot add";
    $check = "select address from wallet where address = '$address'";
    $available = mysqli_query($connection,$check) or die(mysqli_error());
    if(mysqli_num_rows($available) > 0)
    { 
        echo "<h3>adding before</h3>"; 
    } else {
        if($address and $point){
            $sql1 = "insert into wallet(address,point) values ('$address','$point')";
            $q1 = mysqli_query($connection,$sql1);
            if($q1){
                $msg = "Succesfully";
            }
        }
        $data['data']['result'] = $msg;
        echo json_encode($data);
    }
}

function detail(){
    global $connection;
    $address =$_GET['address'];
    $sql1 = "select * from wallet where address = '$address'";
    $q1 = mysqli_query($connection,$sql1);
    while ($r1 = mysqli_fetch_array($q1)){
        $output[]= array(
            'id_user' => $r1['id_user'],
            'address' => $r1['address'],
            'point' => $r1['point']
        );
    }
    $data['data']['result'] = $output;
    echo json_encode($data);
}

// function leaderboard(){
//     global $connection;
//     // $address =$_GET['address'];
//     $sql1 = "select * from wallet order by id_user desc";
//     $q1 = mysqli_query($connection,$sql1);
//     while ($r1 = mysqli_fetch_array($q1)){
//         $output[]= array(
//             'id_user' => $r1['id_user'],
//             'address' => $r1['address'],
//             'point' => $r1['point']
//         );
//     }
//     $data['data']['result'] = $output;
//     echo json_encode($data);
// }

function leaderboard(){
    global $connection;
    $sql1 = "select * from wallet order by point desc";
    $q1 = mysqli_query($connection,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $output[] = array(
            'id_user' => $r1['id_user'],
            'address' => $r1['address'],
            'point'  => $r1['point']
        );
    } 
    $data['data']['result'] = $output;
    echo json_encode($data); 
}

function update(){
    global $connection;
    $address = $_GET['address'];
    // $check = "select point from wallet where address = '$address'";
    // $int = (int) mysqli_query($connection,$check);
    $point = $_POST['point'] + $_POST['currentpoint'];
    $set[] = "point = '$point' ";
    $msg = "Failed To Update";
    $sql1 = "update wallet set ".implode(",",$set)." where address = '$address'";
    $q1 = mysqli_query($connection,$sql1);
    if($q1){
        $msg = "Data Update Succesfully";
    }
    $data['data']['result'] = $msg;
    echo json_encode($data);
}


function getPoint(){
    global $connection;
    $address = $_GET['address'];
    $sql1 = "select point from wallet where address = '$address'";
    $q1 = mysqli_query($connection,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $output[] = array(
            'point' => $r1['point']
        );
    } 
    $data['data']['result'] = $output;
    echo json_encode($data); 
}