<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");

// set the $servername, $dbname, $username, and $password
include 'dbconfig.php';
include 'StatusCRUD.php';

// crudStatus instance creation using OOP approach
$crudStatus = new StatusCRUD('read', null, null, null);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and execute
    $stmt = $conn->prepare("SELECT * FROM marks");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        $crudStatus->data = $result;
        $crudStatus->status = 'success';
    } else {
        $crudStatus->status = 'fail';
        $crudStatus->error_msg = 'No records found';
    }
} catch (PDOException $e) {
    $crudStatus->status = 'fail';
    $crudStatus->error_msg = $e->getMessage();
}

echo json_encode($crudStatus);
?>
