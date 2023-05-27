<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// if (!isset($_SESSION['result'])){
    
//     // $_SESSION['result'] = $result;
//     // $_SESSION['nloop'] = 0;
//     // echo 'yes';
// } else {
//     $result = $_SESSION['result'];
// }


// print_r($result);

// mysqli_data_seek($result, $_SESSION['nloop']);

// $data = mysqli_fetch_assoc($result);
// print_r($data);
// if ($data['parentNode'] != 0){
//     array_push($_SESSION['already'], $data['id']);
//     $_SESSION += $data;
// }

// $_SESSION['nloop']+1;

// echo $_SESSION['nloop'];

// print_r($_SESSION);


// $complete = array();
// $a = 0;
// do {
//     $data = mysqli_fetch_assoc($result);

//     array_push($already, $data['id']);
//     $requestID = $data['id'];
//     include('../modules/getDataFromSQL.php');
//     $_GET['mode'] = 'raw';
//     $tickets = array();

//     $_GET['id'] = $data['id'];
//     $IDs = array($data['id']);
//     ob_start();
//     include '../ticket/index.php';
//     $buyerPDF = ob_get_clean();

//     $i = 0;
//     foreach ($children as $person){
//         if (empty($person)){
//             break;
//         }
//         $_GET['id'] = $person['id'];
//         array_push($IDs, $person['id']);
//         ob_start();
//         include '../ticket/index.php';
//         $ticket = array (
//             'id' => $person['id'],
//             'pdf' => ob_get_clean()
//         );
//         $tickets[$i] = $ticket;
//         $i++;
//     }

//     print_r($tickets);


//     $a++;
// } while ($a <= mysqli_num_rows($result));

require('../../db_config.php');

$sql = "SELECT * FROM `preinscriptions` WHERE date='2023-05-26' AND time < CAST('19:03:00' as time)";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_all($result);


$_SESSION['allowed'] = array();
foreach ($data as $person){
    array_push($_SESSION['allowed'], $person[0]);
}

print_r($_SESSION['allowed']);

?>